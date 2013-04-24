<?

class UserModel extends CI_Model {

    function __construct(){
        parent::__construct();

        $this->load->helper('objectToArray.php');
        $this->load->helper('objectToArray.php');
    }


    // getProfile 
    // Get all of users information and load their profile page
    function getProfile($userID){
    	
    	$this->load->library('subquery');

    	$this->db->select("u.user_id, u.username, u.date_of_reg, u.profile_img");
	 
	   	$subDecks = $this->subquery->start_subquery("select");
		$subDecks->select('COUNT(d.deck_id) as deck_count')->from('users as u');
		$subDecks->join('decks as d', 'u.user_id = d.user_id');
		$subDecks->where("u.user_id = '$userID'");
		$this->subquery->end_subquery('decksCount');

    	$subCards = $this->subquery->start_subquery("select");
    	$subCards->select('COUNT(c.card_id) as card_count')->from('users as u');
    	$subCards->join('decks as d', 'u.user_id = d.user_id');
    	$subCards->join('cards as c', 'd.deck_id = c.deck_id');
		$subCards->where("u.user_id = '$userID'");
    	$this->subquery->end_subquery('cardsCount');

    	$subTags = $this->subquery->start_subquery("select");
    	$subTags->select('COUNT(t.tag_id) as tag_count')->from('users as u');
    	$subTags->join('decks as d', 'u.user_id = d.user_id');
    	$subTags->join('tags as t', 'd.deck_id = t.deck_id');
		$subTags->where("u.user_id = '$userID'");
    	$this->subquery->end_subquery('tagsCount');

    	$subFriends = $this->subquery->start_subquery("select");
    	$subFriends->select('COUNT(uf.friend_id) as friend_count')->from('users as u');
    	$subFriends->join('user_friends as uf', 'u.user_id = uf.user_id');
		$subFriends->where("u.user_id = ", $userID);
        $subFriends->where('uf.active', "1");
        $subFriends->or_where('uf.friend_id', $userID);
        $subFriends->where('uf.active', 1);
    	$this->subquery->end_subquery('friendsCount');

    	$subRatings = $this->subquery->start_subquery("select");
    	$subRatings->select('COUNT(r.rating_id) as rating_count')->from('users as u');
    	$subRatings->join('decks as d', 'u.user_id = d.user_id');
    	$subRatings->join('ratings as r', 'd.deck_id = r.deck_id');
		$subRatings->where("u.user_id = '$userID'");
    	$this->subquery->end_subquery('ratingsCount');

    	$this->db->from('users as u');
    	$this->db->where("u.user_id = '$userID'");

		$query = $this->db->get();


    	 if($query->num_rows > 0){
    		foreach($query->result() as $row){
    			$dataResults[] = $row;
    		}
    	}else{
    		// No Results Found
    		echo "No Results";
    	}

        // echo '<pre>';
        // print_r($dataResults);
        // echo '</pre>';

    	if(isset($dataResults)){

            $dataResults = objectToArray($dataResults);

    		return $dataResults;

    	}else{
    		return false;
    	} 
    }


    // getAll
    // Retrieve all users and their ratings count from database for users page
    function getAll($sortBy){

        $this->db->select('user_id');
        $query = $this->db->get('users');

        if($query->num_rows > 0){
            foreach($query->result() as $row){

                $this->db->select("u.user_id, username, profile_img, COUNT(r.rating_id) as ratingCount, u.date_of_reg");
                $this->db->join('decks as d', 'u.user_id = d.user_id');
                $this->db->join('ratings as r', 'd.deck_id = r.deck_id');
                $this->db->where('u.user_id', $row->user_id);

                $q = $this->db->get('users as u');


                if($q->num_rows() > 0){
                    
                    foreach($q->result() as $r){
                        $dataResults[] = $r; 
                    }

                }else{
                    // No Results Found
                }

            } // end of foreach1


            // Return the array of users with the top users on the top
            function compareRatings($a, $b) {
                return $b["ratingCount"] - $a["ratingCount"];
            }

            // Return the array of users with the newest registered users on the top
            function sortByNewest($a, $b){
                $t1 = strtotime($a['date_of_reg']);
                $t2 = strtotime($b['date_of_reg']);

                return $t2 - $t1;
            }


            // Return the array of users with the oldest users on the top
            function sortByOldest($a, $b){
                $t1 = strtotime($a['date_of_reg']);
                $t2 = strtotime($b['date_of_reg']);

                return $t1 - $t2;
            }

            // Converting results from query from StdObject to array
            $dataResults = objectToArray($dataResults);

            // Determining which way to sort users
            switch($sortBy){
                case "top":
                    usort($dataResults, "compareRatings");
                break;

                case "newest":
                    usort($dataResults, "sortByNewest");
                break;

                case "oldest":
                    usort($dataResults, "sortByOldest");
                break;

                default:

                break;
            }

            if(isset($dataResults)){
                return $dataResults;
            }else{
                return false;
            }
        
        } // end of if
    
    } // end of getAll



    // getTopUsers
    // Get a list of the 6 top users to be displayed on the decks page
    function getTopUsers(){

        $this->db->select('u.user_id, u.username, COUNT(r.rating_id) as ratingCount');
        $this->db->from('users as u');
        $this->db->join('decks as d', 'u.user_id = d.user_id');
        $this->db->join('ratings as r', 'd.deck_id = r.deck_id');
        $this->db->group_by('u.user_id');
        $this->db->order_by('ratingCount', 'desc');
        $this->db->limit('6');

        $query = $this->db->get();

        if($query->num_rows > 0){
            foreach($query->result() as $row){
                $dataResults[] = $row;
            }

            // echo "<pre>";
            // print_r($dataResults);
            // echo "</pre>";

            return $dataResults;
        }else{
            // No users found;
        }
    }


    // userSearch
    function userSearch($searchQuery){

        $this->db->distinct();
        $this->db->select();
        // $this->db->join("tags", "decks.deck_id = tags.deck_id");
        $this->db->like("u.username", $searchQuery);
        $query = $this->db->get("users as u");

        var_dump($query);
    }







} // end of user class