(function(){
  
  Renderer = function(canvas){

    // Initialize canvas variables
    var dom = $(canvas)
    var canvas = dom.get(0)
    var ctx = canvas.getContext("2d");
    var gfx = arbor.Graphics(canvas)
    var particleSystem = null

    //Initialize canvas width and height based on browswer window size
    ctx.canvas.width  = window.innerWidth;
    ctx.canvas.height = window.innerHeight-$('#nav').height();

    var that = {
      init:function(system){

        //Initialize system from main.js
        particleSystem = system
        particleSystem.screenSize(canvas.width, canvas.height) 
        particleSystem.screenPadding(40)

        that.initMouseHandling()
      },
      
      redraw:function(){
        if (!particleSystem) return

        gfx.clear() // convenience ƒ: clears the whole canvas rect

        // draw the nodes & save their bounds for edge drawing
        var nodeBoxes = {}
        particleSystem.eachNode(function(node, pt){
          // node: {mass:#, p:{x,y}, name:"", data:{}}
          // pt:   {x:#, y:#}  node position in screen coords

          // determine the box size and round off the coords if we'll be 
          // drawing a text label (awful alignment jitter otherwise...)
          var label = node.data.label||""
          if (!(""+label).match(/^[ \t]*$/)){
            pt.x = Math.floor(pt.x)
            pt.y = Math.floor(pt.y)
          }else{
            label = null
          }

          // Init var for shadow color of collapsed nodes
          var collapse;

          // Setup node attributes based on word-type 
          switch(node.data.type){
              case 'category':
                  ctx.fillStyle = 'green';
                  collapse = 'red';
                  label = label.pluralize();
                  break;
              case 'verb':
                  ctx.fillStyle = 'red';
                  collapse = 'blue';
                  break;
              case 'noun':
                  ctx.fillStyle = 'blue'
                  break;
              default:
                  ctx.fillStyle = "black"
                  node.fixed = true
          }
          
          var w = ctx.measureText(""+label).width + 10
          node.data.radius = w/2
          var off = w/15
          var textColor = "white"
          
          if(node.data.hovered=='y'){
              textColor = ctx.fillStyle
              ctx.fillStyle = "white"
          }

          var shadow = node.data.expanded ? 'black' : collapse;
          
          switch(node.data.type){
              case 'category':
                  gfx.oval(pt.x-w/2+off, pt.y-w/2+off, w,w, {fill:shadow})
                  gfx.oval(pt.x-w/2, pt.y-w/2, w,w, {fill:ctx.fillStyle})
                  nodeBoxes[node.name] = [pt.x-w/2, pt.y-w/2, w+off,w+off]
                  break;
              case 'me':
                  // gfx.rect(pt.x-w/2+off, pt.y-10+off, w,20, 4, {fill:shadow})
                  gfx.rect(pt.x-w, pt.y-20, w*2,40, 4, {fill:ctx.fillStyle})
                  nodeBoxes[node.name] = [pt.x-w, pt.y-22, w*2+off, 44+off]
                  break;
              default:
                  gfx.rect(pt.x-w/2+off, pt.y-10+off, w,20, 4, {fill:shadow})
                  gfx.rect(pt.x-w/2, pt.y-10, w,20, 4, {fill:ctx.fillStyle})
                  nodeBoxes[node.name] = [pt.x-w/2, pt.y-11, w+off, 22+off]
          }
          // draw the text
          if (label){
            ctx.font = "12px Helvetica"
            ctx.textAlign = "center"
            ctx.fillStyle = textColor
            ctx.fillText(label||"", pt.x, pt.y+4)
            // ctx.fillText(label||"", pt.x, pt.y+4)
          }
        })    			
        // draw the edges
        particleSystem.eachEdge(function(edge, pt1, pt2){
          // edge: {source:Node, target:Node, length:#, data:{}}
          // pt1:  {x:#, y:#}  source position in screen coords
          // pt2:  {x:#, y:#}  target position in screen coords
          var weight = 1;
          var color = 'black';
          
          switch(edge.data.type){
              case 'category':
                  weight = 3
                  break;
              case 'verb':
                  weight = 2
                  break;
              case 'noun':
                  var edges = particleSystem.getEdgesTo(edge.target)
                  if(edges.length > 1) color = 'purple';
                  break;
          }
          
          if (!color || (""+color).match(/^[ \t]*$/)) color = null

          // find the start point
          var tail = intersect_line_box(pt1, pt2, nodeBoxes[edge.source.name])
          var head = intersect_line_box(tail, pt2, nodeBoxes[edge.target.name])

          ctx.save() 
            ctx.beginPath()
            ctx.lineWidth = (!isNaN(weight)) ? parseFloat(weight) : 1
            ctx.strokeStyle = (color) ? color : "#cccccc"
            ctx.fillStyle = null
                        
            ctx.moveTo(tail.x, tail.y)
            ctx.lineTo(head.x, head.y)
            ctx.stroke()
          ctx.restore()

          // draw an arrowhead 
            ctx.save()
              // move to the head position of the edge we just drew
              var wt = !isNaN(weight) ? parseFloat(weight) : 1
              var arrowLength = 9 + wt
              var arrowWidth = 5 + wt
              ctx.fillStyle = (color) ? color : "#cccccc"
              ctx.translate(head.x, head.y);
              ctx.rotate(Math.atan2(head.y - tail.y, head.x - tail.x));

              // delete some of the edge that's already there (so the point isn't hidden)
              ctx.clearRect(-arrowLength/2,-wt/2, arrowLength/2,wt)

              // draw the chevron
              ctx.beginPath();
              ctx.moveTo(-arrowLength, arrowWidth);
              ctx.lineTo(0, 0);
              ctx.lineTo(-arrowLength, -arrowWidth);
              ctx.lineTo(-arrowLength * 0.8, -0);
              ctx.closePath();
              ctx.fill();
            ctx.restore()
        })
      },
      initMouseHandling:function(){
        // no-nonsense drag and drop (thanks springy.js)
        selected = null;
        nearest = null;
        var dragged = null;
        var oldmass = 1
        var move = 0

        // set up a handler object that will initially listen for mousedowns then
        // for moves and mouseups while dragging
        var handler = {
          moved:function(e){
            var pos = $(canvas).offset();
            _mouseP = arbor.Point(e.pageX-pos.left, e.pageY-pos.top);
            nearest = particleSystem.nearest(_mouseP);

            if(!nearest.node){
                return false;
            }

            selected = (nearest.distance < nearest.node.data.radius) ? nearest : null
            
            if(selected) dom.addClass('hovered');
            else dom.removeClass('hovered');
      
            return false;
          },

          down:function(e){
            var pos = $(canvas).offset();
            _mouseP = arbor.Point(e.pageX-pos.left, e.pageY-pos.top)
            nearest = dragged = particleSystem.nearest(_mouseP);
            move = 0
            
            if (dragged && dragged.node !== null){
                dragged.node.fixed = true
            }

            $(canvas).bind('mousemove', handler.dragged)
            $(window).bind('mouseup', handler.dropped)

            return false
          },
          dragged:function(e){
            var old_nearest = nearest && nearest.node._id
            var pos = $(canvas).offset();
            var s = arbor.Point(e.pageX-pos.left, e.pageY-pos.top)
            move = 1

            if (!nearest) return
            if (dragged !== null && dragged.node !== null){
              var p = particleSystem.fromScreen(s)
              dragged.node.p = p
            }

            return false
          },

          dropped:function(e){
            if (dragged===null || dragged.node===undefined) return
            if (dragged.node !== null) {
                if(move===0) {
                    if(!dragged.node.data.expanded){
                        if(dragged.node.data.type !== 'noun'){
                            dragged.node.data.expanded = true
                            var nodes = globalData['nodes'][dragged.node.name];
                            var edges = globalData['edges'][dragged.node.name];

                            for (var i in nodes) {
                              particleSystem.addNode(nodes[i].name, nodes[i].data)
                            }

                            for (var i in edges) {
                              if (edges[i] !== undefined)
                                particleSystem.addEdge(edges[i].source.name, edges[i].target.name, edges[i].data)
                            }
                        }
                    }
                    else{
                        dragged.node.data.expanded = false;

                        var nodes = [];
                        var edges = [];

                        if(dragged.node.data.type == 'category'){
                            particleSystem.prune(function(node, from, to){
                                if(node.name.substring(0, dragged.node.data.label.length) === dragged.node.data.label){ 
                                    
                                    nodes[node.name] = node;
                                    for (var i =0; i<from.from.length; i++) {
                                      edges[from.from[i]._id] = from.from[i];
                                    }

                                    for (var i =0; i < from.to.length; i++) {
                                      edges[from.to[i]._id] = from.to[i];
                                    } 

                                    return true;
                                }
                            })

                        }else if(dragged.node.data.type == 'verb'){
                            var draggedEdges = particleSystem.getEdgesFrom(dragged.node)
                            for (var i = 0; i < draggedEdges.length; i++){
                                var edge = draggedEdges[i]
                                nodes[edge.target.name] = edge.target;
                                edges[edge._id] = edge;

                                if(particleSystem.getEdgesTo(edge.target).length == 1){
                                    particleSystem.pruneNode(edge.target)
                                }
                                else{
                                    particleSystem.pruneEdge(edge)
                                }
                            }
                        }

                        globalData['nodes'][dragged.node.name] = nodes;                                   
                        globalData['edges'][dragged.node.name] = edges; 
                    }
                }
                dragged.node.fixed = false
            }
            dragged.node.tempMass = 1000
            dragged = null
            selected = null
            $(canvas).unbind('mousemove', handler.dragged)
            $(window).unbind('mouseup', handler.dropped)
            _mouseP = null
            return false
          }
        }
        
        $(canvas).mousedown(handler.down);
        $(canvas).mousemove(handler.moved);
      }
    }

    // helpers for figuring out where to draw arrows (thanks springy.js)
    var intersect_line_line = function(p1, p2, p3, p4)
    {
      var denom = ((p4.y - p3.y)*(p2.x - p1.x) - (p4.x - p3.x)*(p2.y - p1.y));
      if (denom === 0) return false // lines are parallel
      var ua = ((p4.x - p3.x)*(p1.y - p3.y) - (p4.y - p3.y)*(p1.x - p3.x)) / denom;
      var ub = ((p2.x - p1.x)*(p1.y - p3.y) - (p2.y - p1.y)*(p1.x - p3.x)) / denom;

      if (ua < 0 || ua > 1 || ub < 0 || ub > 1)  return false
      return arbor.Point(p1.x + ua * (p2.x - p1.x), p1.y + ua * (p2.y - p1.y));
    }

    var intersect_line_box = function(p1, p2, boxTuple)
    {
      var p3 = {x:boxTuple[0], y:boxTuple[1]},
          w = boxTuple[2],
          h = boxTuple[3]

      var tl = {x: p3.x, y: p3.y};
      var tr = {x: p3.x + w, y: p3.y};
      var bl = {x: p3.x, y: p3.y + h};
      var br = {x: p3.x + w, y: p3.y + h};

      return intersect_line_line(p1, p2, tl, tr) ||
            intersect_line_line(p1, p2, tr, br) ||
            intersect_line_line(p1, p2, br, bl) ||
            intersect_line_line(p1, p2, bl, tl) ||
            false
    }
    
    return that
  }    
  
})()
