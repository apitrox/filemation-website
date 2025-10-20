<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Role_permissions_model.php
 */
class Role_permissions_model extends Model {

	public function Role_permissions_model()
	{
		parent::Model();
	}


	//  This method is used to retrieve an individual role_permission record from the database.
	//  Param 1:  role_permission_id for the role_permission record to be retrieved
	//  return:  an object containing the role_permission record, or NULL if nothing was retrieved or error
	function GetRolePermission( $role_permission_id )
	{
		//  validate argument
		if ( is_null( $role_permission_id ) || empty($role_permission_id) ) return NULL ;
		if ( is_object( $role_permission_id ) ) return NULL ;
		if ( !is_numeric( $role_permission_id ) ) return NULL ;
		if ( $role_permission_id == 0 ) return NULL ;

		$this->db->where('Role_Permission_Id', $role_permission_id );
		$role_perm_query = $this->db->get('role_permissions');

		$role_perm = $role_perm_query->row() ;  //  set the role_permission

		//  validate the query result
		if ( $role_perm_query->num_rows() != 1)  return  NULL ;    //  invalid result, return NULL
		if ( is_null( $role_perm ) || empty( $role_perm ) )  return  NULL ;    //  missing or empty object, return NULL
		if (!is_object( $role_perm ) )  return  NULL ;    //  invalid result type, return NULL
		if ( !isset( $role_perm->Role_Permission_Id ) )  return  NULL ;    //  missing key, return NULL
		if ( is_null( $role_perm->Role_Permission_Id ) || empty( $role_perm->Role_Permission_Id ) )  return  NULL ;    //  invalid key value, return NULL
		if ( !is_numeric( $role_perm->Role_Permission_Id ) )  return  NULL ;    //  invalid key  type, return NULL
		if ( $role_perm->Role_Permission_Id == 0 )  return  NULL ;    //  invalid key value, return NULL

		//  if we get here, everything should be good
		return $role_perm ;
	}


	// This method returns all role_permissions records related with the specified Role_Code
	// Param 1: STR Role_Code
	// Return : MySQL Result of all role_permissions related to Role_Code, NULL if error
	function GetAllPermissionsForRole( $role_code )
	{
		//  validate argument
		if ( is_null( $role_code ) || empty($role_code) ) return NULL ;
		if ( is_object( $role_code ) ) return NULL ;
		if ( strlen($role_code) <= 2 ) return NULL ;

		$this->db->where('roles.Role_Code', $role_code);
		$this->db->where('roles.Role_Code = role_permissions.Role_Code');
		$result = $this->db->get('role_permissions, roles');

		return $result;
	}


	//  This method is used to save an individual role_permission record to the database.
	//  Use an array when possible with only the fields of interest.
	//  If an array is used, it must contain a item "Role_Permission_Id" with the Id of the record to update
	//  Using an entire record object may overwrite data in fields modified since the object values were retrieved from the DB.
	//  Param 1:  an object OR array containing the permission record to be saved
	//  return:  False=if aborted or invalid;   otherwise True
	function SaveRolePermission( $role_permission )
	{
		//  validate arguments passed to this routine by the calling routine
		if ( is_null( $role_permission ) || empty( $role_permission ) )  return  FALSE ;    //  invalid argument, Abort
		if ( !is_array( $role_permission ) && !is_object( $role_permission ) )  return  FALSE ;    //  invalid argument type, Abort
		if ( is_array($role_permission) && !isset($role_permission['Role_Permission_Id']) )  return  FALSE ;    //  if an array, the array must include the record key
		if ( is_array($role_permission) && empty($role_permission['Role_Permission_Id']) )  return  FALSE ;    //  the array record key must not be empty
		if ( is_object($role_permission) && !isset($role_permission->Role_Permission_Id) )  return  FALSE ;    //  if an object, the object must include the record key
		if ( is_object($role_permission) && empty($role_permission->Role_Permission_Id) )  return  FALSE ;    //  the object record key must not be empty

		//  set the role_permission_id based on the data type provided
		$role_permission_id = is_array($role_permission) ? $role_permission['Role_Permission_Id'] : $role_permission->Role_Permission_Id ;

		//  valid record key to avoid data corruption
		$key_check = $this->GetRolePermission( $role_permission_id ) ;
		if ( is_null($key_check) || empty($key_check) || !is_object($key_check) )  return  FALSE ;    //  if record key did not return valid record, abort

		if( is_array($role_permission) )
		{
			//  remove key value from update array/object, key value cannot be updated
			unset($role_permission['Role_Permission_Id']) ;
		}
		elseif ( is_object($role_permission) )
		{
			//  remove key value from update array/object, key value cannot be updated
			unset($role_permission->Role_Permission_Id) ;
		}
		else
		{
			//  something went wrong
			return FALSE;
		}

		// if we get here, we are ready to save the changes to the database
		$this->db->where( 'Role_Permission_Id', $role_permission_id ) ;
		$this->db->update( 'role_permissions', $role_permission ) ;

		//  executed to completion
		return TRUE ;

	}
	
	// This model method saves to the database all permissions for give role
	// @Param 1:	required, Role Code [unique]
	// @Param 2:	required, assoc array of permissions to associate with role
	// @Return:		
	public function SaveAllPermissionsForRole( $role_code, $permissions_array )
	{
		if( empty($role_code) || is_null($role_code) ) return array('Result' => FALSE, 'Result_Message' => 'Role Code invalid or missing data');
		if( !is_array($permissions_array) || empty($permissions_array) ) return array('Result' => FALSE, 'Result_Message' => 'Permissions invalid or missing data');
		
		// first delete all current permissions for role
		$this->db->where('Role_Code', $role_code);
		$del_result = $this->db->delete('role_permissions');
		
		// second lets add all new permissions for role
		foreach($permissions_array as $perm => $value)
		{
			unset($record);
			$record = array();
			$record['Role_Code'] = $role_code;
			$record['Permission_Code'] = $perm;
			$record['Is_Permission_Granted'] = $value;
			$this->db->insert('role_permissions', $record);
		}
		
		return array('Result' => TRUE);
	}


}
/* End of file role_permissions_model.php */
/* Location: ./application/models/role_permissions_model.php */