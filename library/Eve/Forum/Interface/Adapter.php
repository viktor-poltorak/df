<?php

	interface Eve_Forum_Interface_Adapter {

		public function setDbAdapter($adapter);

		/**
		 *  register a new user
		 */
		public function register($userIndo);

		/**
		 * login user
		 */
		public function login($email, $password);

		/**
		 * logout user
		 */
		public function logout($userId);

		/**
		 *  remove users account
		 */
		public function unregister($userId);

		/**
		 * update a given user
		 * @param int $userId
		 * @param array $bind
		 */
		public function update($userId, $bind);

		/**
		 * add given user to group
		 * @param int $userId
		 * @param int $groupId
		 */
		public function addToGroup($userId, $groupId);

	}