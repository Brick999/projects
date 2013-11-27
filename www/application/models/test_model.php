<?php
	class Test_Model extends CI_Model
	{
		function __construct()
		{
			parent::__construct();
		}
		
		public function get_user($user_info, $user_id = NULL)
		{
			if($user_id != NULL)
			{
				$select_user = $this->db->where("id", $user_id)
								->get("users")
								->row();
			}
			else
			{
				$select_user = $this->db->where("email", $user_info["email"])
										->where("password", $user_info["password"])
										->get("users")
										->row();
			}
			
			if($select_user)
			{
				return $select_user;
			}
			else
			{
				$select_user = $this->db->where("email", $user_info["email"])
										->get("users")
										->row();
				
				if($select_user)
				{
					return "wrong pass";
				}
				else
				{
					return "no email";
				}
			}
		}
		
		public function insert_user($user_info)
		{
			$this->db->insert("users", $user_info);
			return $this->db->where("email", $user_info["email"])
							->get("users")
							->row();
		}
		
		public function edit_user($user_info)
		{
			$this->db->where("id", $user_info["id"]);
			$this->db->update("users", $user_info);
			
			return $this->db->where("id", $user_info["id"])
							->get("users")
							->row();
		}
		
		public function get_all_users()
		{
			$all_users = $this->db->select("users.id, 
											users.first_name, 
											users.last_name, 
											users.email, 
											users.created_at, 
											user_levels.user_level
											")
								  ->join("user_levels", "users.user_level_id = user_levels.id")
								  ->get("users");
			
			return $all_users;
		}
		
		public function get_messages($user_id)
		{
			$posted_messages = $this->db->select("messages.message,
												  messages.created_at,
												  users.first_name,
												  users.last_name,
												  ")
										->where("user_id", $user_id)
										->join("users", "messages.user_id = users.id")
										->get("messages");

			return $posted_messages;
		}
		
		public function delete_user($user_id)
		{
			$this->db->delete("users", array("id" => $user_id));
			return "User successfully deleted.";
		}
	}

//end of file