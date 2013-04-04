<?php

class Nodes_Controller extends Base_Controller {

	public $restful = true;    

	public function __construct() {
		$this->filter('before', 'auth')->only(array('graph'));
	}

    // Sends graph and username to 'nodes' view
	public function get_graph()
    {
    	return View::make('nodes.your_nodes')
    		->with('title', 'Accomplishments - Your Graph')
    		->with('username', Auth::user()->username)
    		->with('graph', $this->graph_out());
    }

    // Add Sentence to graph (AJAX call)
    public function post_add()
    {
    	$category = Input::get('category');
    	$verb = Input::get('verb');
    	$noun = Input::get('noun');

        $message = $this->add_nodes($category, $verb, $noun);

    	echo $message;
    }

    // IN: category, verb, and noun from user input
    // OUT: Message indicating success of add
    private function add_nodes($c_word, $v_word, $n_word)
	{
		$user = Auth::user();

		$category = $user->categories()->where_word($c_word)->first();
		if (!$category) {

			$category = new Category(array('word' => $c_word));
			$category = $user->categories()->insert($category);	
		}

		$verb = $category->verbs()->where_word($v_word)->first();
		if (!$verb) {

			$verb = new Verb(array('word' => $v_word));
			$verb = $category->verbs()->insert($verb);	
		}

        // Checks if user-entered noun already exists beneath category
        // (checks multiple verbs)
		$noun = $category->get_noun($n_word);

		if (!$noun) {

			$noun = new Noun(array('word' => $n_word));
			$verb->nouns()->insert($noun);

		} else if (!$verb->nouns()->where_word($n_word)->first()) {

			$verb->nouns()->attach($noun->id);
	    }
	    else
	    	return 'exists';
		
		if($category && $verb && $noun)
			return 'inserted';
		else
			return 'failed';
	}

    // IN: N/A
    // OUT: An array of nodes and edges that will be converted to JSON
	private function graph_out() {
		$nodes = array();
        $edges = array();

        $user = Auth::user();
        $username = $user->username;
        
        $nodes[$username] = array(
            'label' => $username,
            'type' => 'user',
            'expanded' => true
        );        

        if($categories = $user->categories) {
            $edges[$username] = array();
        }

        foreach($categories as $category){
        	$cat_unique = $username . "_" . $category->word;

        	$nodes[$cat_unique] = array(
                'type' => 'category',
                'label' => $category->word,
                'expanded' => true
            );
                            
            $edges[$username][$cat_unique] = array('type' => 'category');
            
            $verbs = $category->verbs;
            $edges[$cat_unique] = array();

            foreach($verbs as $verb){
                $verb_unique = $category->word . '_' . $verb->word;

                $nodes[$verb_unique] = array(
                    'type' => 'verb',
                    'label' => $verb->word,
                    'expanded' => true
                );
                
                $edges[$cat_unique][$verb_unique] = array('type' => 'verb');
                
                $nouns = $verb->nouns;
                $edges[$verb_unique] = array();
                
                foreach($nouns as $noun){
                    $noun_unique = $category->word . '_' . $noun->word;

                    $nodes[$noun_unique] = array(
                        'type' => 'noun',
                        'label' => $noun->word,
                        'expanded' => true
                    );
                    
                    $edges[$verb_unique][$noun_unique] = array('type' => 'noun');
                }
            }
        }

        $graph = array(
        	'nodes' => $nodes,
        	'edges' => $edges
        );

        return $graph;
	}
}