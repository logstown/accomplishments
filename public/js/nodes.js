$(document).ready(function(){
    var oneNode = jQuery.isEmptyObject(graph.edges); // True if user's graph contains only one node (empty)
    var sys = arbor.ParticleSystem() // initialize particle system
      
    // Sentence placeholder logic
    $('#noun').data('nholder',$('#noun').attr('placeholder'));
    $('#category').data('cholder',$('#category').attr('placeholder'));
    $('#verb').data('vholder',$('#verb').attr('placeholder'));

    $('#noun').focusin(function(){
        $(this).attr('placeholder','');
    });
    $('#noun').focusout(function(){
        $(this).attr('placeholder',$(this).data('nholder'));
    });

    $('#category').focusin(function(){
        $(this).attr('placeholder','');
    });
    $('#category').focusout(function(){
        $(this).attr('placeholder',$(this).data('cholder'));
    });

    $('#verb').focusin(function(){
        $(this).attr('placeholder','');
    });
    $('#verb').focusout(function(){
        $(this).attr('placeholder',$(this).data('vholder'));
    });
    
    // Graph is drawn
    sys.parameters({gravity:false}) // use center-gravity to make the graph settle nicely (ymmv)
    sys.renderer = Renderer("#viewport") // our newly created renderer will have its .init() method called shortly by sys...
    sys.graft(graph)

    // If graph is empty, add node to tell user to Enter a sentence
    if(oneNode) {
        sys.addNode("add", {type:"add", label:"Enter Sentence Above", expanded: true})
        sys.addEdge(user, "add", {type: "category"})
    }

    // The 'add' button has been clicked.
    $(":submit").click(function(e){
        e.preventDefault();

        // Check for at least one blank input
        if( !$('#noun').val() || !$('#category').val() || !$('#verb').val() )  {
            $("#message").html('One or more fields are blank');
        }
        else 
        {
            // AJAX call to add function in 'nodes' controller
            $.post('add', $("form.form-inline").serialize(), 
              function(data) {

                switch(data) {
                    case 'failed':
                        $("#message").html("Your sentence failed to be inserted!");
                        break;

                    case 'exists':
                        $("#message").html("Your sentence already exists!");
                        break;

                    default:
                        if(oneNode) {
                            sys.pruneNode("add")
                            oneNode = false;
                        }

                        insertSentence(sys);
                        
                        $("#message").html("Inserted!");
                        break;
                }

                $(":text").val('');
                $("#noun").focus();
            });
        }

        flashMessage();
    });
});

// Insert sentence to particle system (client-side only)
function insertSentence(sys) {
    var category  = $('#category').val().toLowerCase();
    var verb  = $('#verb').val().toLowerCase();
    var noun  = $('#noun').val().toLowerCase();

    // Create unique hierarchical values in case of duplicates
    var cat_unique = user + '_' + category;
    var verb_unique = category + '_' + verb;
    var noun_unique = category + '_' + noun;

    if(sys.getEdges(user, cat_unique).length === 0){
        sys.addNode(cat_unique, {type:"category", label:category, expanded:true})
        sys.addEdge(user, cat_unique, {type:"category"})           
    }
    if(sys.getEdges(cat_unique, verb_unique).length === 0){
        sys.addNode(verb_unique, {type:"verb", label:verb, expanded:true})
        sys.addEdge(cat_unique, verb_unique, {type:"verb"})
    }
    if(sys.getNode(noun_unique) === undefined){
        sys.addNode(noun_unique, {type:"noun", label:noun, expanded:true})
    }
    sys.addEdge(verb_unique, noun_unique, {type:"noun"})
}
