<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Lams Online 1.0, 1.5
 *
 * Users and Permissions
 */
 
class User_permissions_model extends Model {

    public function User_permissions_model()
    {
        parent::Model();
    }


	//  This determines if this user has or does not have a specified permission.
	//  "This user" is the current user
	// Param 1: Permission_Code
	// @return : TRUE=user has permission, FALSE=user does not have permission
	public function DoesUserHavePermission( $permission_code )
	{
		$thisUserID = $this->tank_auth->get_user_id() ;

		$this->db->where( 'User_Id', $thisUserID ) ;
		$this->db->where( 'Permission_Code', $permission_code ) ;
		$user_permission_query = $this->db->get('user_permissions');

		if ( $user_permission_query->num_rows() == 1 )
		{
			$user_permission = $user_permission_query->row() ;
			if ( $user_permission->Is_Permission_Granted == 1 )
			{
				return TRUE ;   // this user has the permission
			}
			else
			{
				return FALSE ;  // no permission
			}
		}
		elseif ( $user_permission_query->num_rows() == 0 )
		{
			//  if this permission has not been specifically set for this user,
			//  then attempt to get the default permission setting out of the permissions table
			$this->db->where( 'Permission_Code', $permission_code ) ;
			$permission_query = $this->db->get('permissions');
			if ( $permission_query->num_rows() == 1 )
			{
				$permission = $permission_query->row() ;
				if ( $permission->Permission_Default == 1 )
				{
					return TRUE ;   // default is to grant permission
				}
				else
				{
					return FALSE ;   // permission default is NO permission
				}
			}
		}

		return FALSE;

	}


	//  This will set all of a user's permissions to match the permissions for the role the user is assigned to.
	//  Param 1:  The user_id of the user of interest
	// @return : TRUE=if executes to completion, FALSE=if error or aborted
	public function ResetUserPermissionsToMatchRole( $user_id)
	{
		$CI =& get_instance();
		$CI->load->model('Users_model');
		$CI->load->model('Role_permissions_model');

		//  validate argument
		if ( is_null( $user_id ) || empty($user_id) ) return FALSE ;
		if ( is_object( $user_id ) ) return FALSE ;
		if ( !is_numeric( $user_id ) ) return FALSE ;
		if ( $user_id == 0 ) return FALSE ;

		//  get and validate the uer
		$user = $CI->Users_model->GetUser( $user_id ) ;
		if ( is_null( $user ) || empty( $user ) )  return  FALSE ;    //  missing or empty object, return NULL

		//  get all the permissions for the user's assigned role
		$role_permissions = $CI->Role_permissions_model->GetAllPermissionsForRole( $user->User_Role_Code ) ;
		if ( is_null( $role_permissions ) || empty( $role_permissions ) )  return  FALSE ;    //  missing or empty object, return NULL


		//   first delete all existing permissions for this user
		$this->db->where( 'User_Id', $user_id ) ;
		$this->db->delete( 'user_permissions' ) ;


		if ( $role_permissions->num_rows() > 0 )
		{
			foreach ( $role_permissions->result() as $role_permission )
			{
				$this->db->set( 'User_Id', $user_id ) ;
				$this->db->set( 'Permission_Code', $role_permission->Permission_Code ) ;
				$this->db->set( 'Is_Permission_Granted', $role_permission->Is_Permission_Granted ) ;
				$this->db->insert( 'user_permissions' ) ;
			}
		}

		//  if we get here, return a false
		return TRUE ;

	}


	// This method is used throughout the application to check if the current user has the provided permission set ON/1
	// Param 1:  Permission_Code in question
	// Param 2:  redirect indicator. TRUE then it will redirect the user if the user does not have the permission set ON/1.
	// Param 3:  the url to redirect the user if the redirect is required. default is the base url of the application
	// @return:  TRUE/FALSE. If redirect is indicated then the user is redirect and return is VOID.
	public function PermissionCheck($permission_code, $redirect_ind = NULL, $redirect_url = '/')
	{

		$result = $this->DoesUserHavePermission($permission_code);

		if($result == TRUE)
		{
			return TRUE;
		}
		 else
		{
			if(!is_null($redirect_ind) && $redirect_ind != FALSE && !empty($redirect_ind))
				redirect($redirect_url);
			else
				return FALSE ;
		}
	}
	
	// This method returns all permissions for a user related with the specified User ID
	// @Param 1: 	required, User ID primary key
	// @Return : 	MySQL Result of all user_permissions related to User ID, NULL if error
	public function GetAllPermissionsForUser( $user_id )
	{
		//  validate argument
		if ( is_null( $user_id ) || empty($user_id) ) return array('Result' => FALSE, 'Result_Message' => 'User ID empty or invalid data');

		$this->db->where('users.User_Id', $user_id);
		$this->db->where('users.User_Id = user_permissions.User_Id');
		$result = $this->db->get('user_permissions, users');

		return $result;
	}
	
	// This model method saves to the database all permissions for give user
	// @Param 1:	required, User ID primary key
	// @Param 2:	required, assoc array of permissions to associate with user
	// @Return:		assoc array Result => false is failure, Result => true is success
	public function SaveAllPermissionsForUser( $user_id, $permissions_array )
	{
		if( empty($user_id) || is_null($user_id) ) return array('Result' => FALSE, 'Result_Message' => 'User ID invalid or missing data');
		if( !is_array($permissions_array) || empty($permissions_array) ) return array('Result' => FALSE, 'Result_Message' => 'Permissions invalid or missing data');
		
		// first delete all current permissions for user
		$this->db->where('User_Id', $user_id);
		$del_result = $this->db->delete('user_permissions');
		
		// second lets add all new permissions for user
		foreach($permissions_array as $perm => $value)
		{
			unset($record);
			$record = array();
			$record['User_Id'] = $user_id;
			$record['Permission_Code'] = $perm;
			$record['Is_Permission_Granted'] = $value;
			$this->db->insert('user_permissions', $record);
		}
		
		return array('Result' => TRUE);
	}

}
/* End of file user_permissions_model.php */
/* Location: ./application/models/user_permissions_model.php */