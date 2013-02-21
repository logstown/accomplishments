$(document).ready(function(){
    var sys = arbor.ParticleSystem(1000, 600, 0.5) // create the system with sensible repulsion/stiffness/friction
    sys.parameters({gravity:true}) // use center-gravity to make the graph settle nicely (ymmv)
    sys.renderer = Renderer("#viewport") // our newly created renderer will have its .init() method called shortly by sys...

    sys.graft(graph)

    $(":submit").click(function(e){
        e.preventDefault();

        $.post('add', $("form.form-inline").serialize(), 
          function(data) {
            var message;

            switch(data) {
                case 'failed':
                    message = "Your sentence failed to be inserted!";
                    break;
                case 'exists':
                    message = "Your sentence already exists!";
                    break;
                default:
                    insertSentence(sys);
                    message = "Inserted!";
            }

            $("#message").html(message);

            $(":text").val('');

        });
    });
});

function insertSentence(sys) {
    var category  = $('#category').val();
    var verb  = $('#verb').val();
    var noun  = $('#noun').val();

    var cat_unique = user + '_' + category;
    var verb_unique = category + '_' + verb;
    var noun_unique = category + '_' + noun;

    if(sys.getEdges(user, cat_unique).length === 0){
        sys.addNode(cat_unique, {type:"category", label:category, hovered:'n', expanded:true})
        sys.addEdge(user, cat_unique, {type:"category"})           
    }
    if(sys.getEdges(cat_unique, verb_unique).length === 0){
        sys.addNode(verb_unique, {type:"verb", label:verb, hovered:'n', expanded:true})
        sys.addEdge(cat_unique, verb_unique, {type:"verb"})
    }
    if(sys.getNode(noun_unique) === undefined){
        sys.addNode(noun_unique, {type:"noun", label:noun, hovered:'n', expanded:true})
    }
    sys.addEdge(verb_unique, noun_unique, {type:"noun"})
}