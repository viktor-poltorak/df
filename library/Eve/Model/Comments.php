<?php
	class Eve_Model_Comments extends Eve_Model_Abstract {
		protected $_name;
		
		protected $_table_users = Eve_Enum_Tables::USERS;

		protected $_table_profiles = Eve_Enum_Tables::PROFILES;
		
		protected $_id_field = 'comment_id';
		
		protected $_related_field;

		public function initialize($table, $relatedField) {
			$this->_name = $table;
			$this->_related_field = $relatedField;
		}
		
		public function add($relatedId, $body) {
			return $this->insert(array(
				$this->_related_field => $relatedId,
				'body' => $body,
				'user_id' => Auth::getAuthInfo()->user_id,
				'date_posted' => new Zend_Db_Expr('NOW()')
			));

		}

		public function get($commentId) {
			$select = $this->getAdapter()->select();
			$select->from($this->_name);
			$select->joinLeft($this->_table_profiles,
				$this->_name.'.user_id = '.$this->_table_profiles.'.linked_user_id', array(
					'photo'
				)
			);
			$select->joinLeft($this->_table_users,
				$this->_table_users.'.user_id = '.$this->_name.'.user_id', array('user_id', 'first_name', 'last_name', 'gender')
			);
			$select->order('date_posted ASC');
			$select->where($this->_id_field.' = ?', $commentId);

			return $select->query()->fetchObject();
		}

		public function getAll($relatedId) {
			$select = $this->getAdapter()->select();
			$select->from($this->_name);
			$select->joinLeft($this->_table_profiles,
				$this->_name.'.user_id = '.$this->_table_profiles.'.linked_user_id', array(
					'photo'
				)
			);
			$select->joinLeft($this->_table_users,
				$this->_table_users.'.user_id = '.$this->_name.'.user_id', array('user_id', 'first_name', 'last_name', 'gender')
			);
			$select->order('date_posted ASC');
			$select->where($this->quoteInto($this->_related_field.' = ?', $relatedId));
			
			return $select->query()->fetchAll();
		}
		
		public function getCommentsCount($relatedId) {
			$select = $this->getAdapter()->select();
			$select->from($this->_name, 'COUNT(*) AS count');
			$select->where($this->_related_field.' = ?', $relatedId);
			
			return $select->query()->fetchObject()->count;
			
		}

		public function replaceLinks($message) {
			preg_match_all('/(http|https|www)\:\/\/([\d\w\.\?\/\-\\\+\%\=\&]+)/', $message, $matches);
			foreach ($matches[0] as $match) {
				$message = str_replace($match, '<a href="'.$match.'" target="_blank">'.$match.'</a>', $message);
			}

			return $message;
		}

		public function replaceUsers($message) {
			preg_match_all('/\{user\:[\d]+\}/', $message, $matchedUsers);
			
			foreach ($matchedUsers[0] as $match) {
				$userId = (int) preg_replace('/([^\d])/', '', $match);

				if ($userId) {
					$users = new Users();
					$user = $users->load($userId);

					if ($user)
						$message = str_replace($match, '<a href="/profile/'.$user->user_id.'/">'.$user->first_name.' '. $user->last_name .'</a>', $message);
					else
						$message = str_replace($match, '<span class="gray">(выбранный пользователь не существует)</span>', $message);
				}

			}

			return $message;
		}

		public function replacePhotos($message) {
			preg_match_all('/\{photo\:[\d]+\}/', $message, $matchedUsers);

			foreach ($matchedUsers[0] as $match) {
				$userId = (int) preg_replace('/([^\d])/', '', $match);

				if ($userId) {
					$photos = new Photos();
					$photo = $photos->load($userId);

					if ($photo)
						$message = str_replace($match, '<a class="comment-attachment-photo" href="/gallery/photo/view/id/'.$photo->photo_id.'/"><img src="/images/gallery/thumbs/thumb_'.$photo->file.'" alt="" /></a>', $message);
					else
						$message = str_replace($match, '<span class="gray">(выбранной фотографии не существует)</span>', $message);
				}

			}

			return $message;
		}

	}