<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Roles and Permissions
 */
class Roles_model extends Model {

    public function Roles_model()
    {
        parent::Model();
    }


	// Get All Roles
	// @return : Result Object of all roles records.
	function GetAllRoles()
	{
		$this->db->order_by('Role_Id', 'ASC');
		return $this->db->get('roles')->result_object();
	}


	//  This method is used to retrieve an individual role record from the database.
	//  Param 1:	role_id for the role record to be retrieved
	//  Param 2:	optional, role code of role to be retrieved	
	//  return:  an object containing the role record, or NULL if nothing was retrieved or error
	function GetRole( $role_id, $role_code = NULL )
	{
		//if( ( empty($role_id) || is_null($role_id) || $role_id == '' ) && ( empty($role_code) || is_null($role_code) || $role_id == '' ) ) return NULL;
		
		if( !is_null($role_id) && !empty($role_id) && $role_id != '' )
		{
			$this->db->where('Role_Id', $role_id );
		}
		
		if( !is_null($role_code) && !empty($role_code) && $role_code != '' )
		{
			$this->db->where('Role_Code', $role_code);
		}
		
		$role_query = $this->db->get('roles');

		$role = $role_query->row() ;  //  set the permission

		//  validate the query result
		if ( $role_query->num_rows() != 1)  return  NULL ;    //  invalid result, return NULL
		if ( is_null( $role ) || empty( $role ) )  return  NULL ;    //  missing or empty object, return NULL
		if (!is_object( $role ) )  return  NULL ;    //  invalid result type, return NULL
		if ( !isset( $role->Role_Id ) )  return  NULL ;    //  missing key, return NULL
		if ( is_null( $role->Role_Id ) || empty( $role->Role_Id ) )  return  NULL ;    //  invalid key value, return NULL
		if ( !is_numeric( $role->Role_Id ) )  return  NULL ;    //  invalid key  type, return NULL
		if ( $role->Role_Id == 0 )  return  NULL ;    //  invalid key value, return NULL

		//  if we get here, everything should be good
		return $role ;
	}


	// Save existing role data into the database table roles
	// @Param 1: array/object to save the database
	// @return : TRUE/FALSE depending on if method saves properly or not.
	function SaveRole($role_data)
	{

		// data validation
		if(is_null($role_data) || empty($role_data) || !is_array($role_data) && !is_object($role_data))  return FALSE;

		$role_id = isset($role_data['Role_Id']) ? $role_data['Role_Id'] : $role_data->Role_Id;
		if(isset($role_data['Role_Id'])) unset($role_data['Role_Id']);
		if(isset($role_data->Role_Id)) unset($role_data->Role_Id);
		if(is_null($role_id) || empty($role_id) || $role_id == 0 || !is_numeric($role_id)) return FALSE;
		$role_data['Role_Active'] = 1;
		
		$this->db->where('Role_Id', $role_id);
		$this->db->update('roles', $role_data);

		return TRUE;
	}


	// Insert new role data into the database table roles
	// @Param 1: array/object to save the database
	// @return : New Role Primary KEY ID, else if negative evaluation of data then FALSE
	function NewRole($role_data)
	{
		// data validation
		if(is_null($role_data) || empty($role_data) || !is_array($role_data) && !is_object($role_data)) return FALSE;
		if(is_array($role_data) && ($role_data['Role_Active'] != '1' || $role_data['Role_Active'] != 1)) $role_data['Role_Active'] = 0;
		if(is_object($role_data) && ($role_data->Role_Active != '1' || $role_data->Role_Active != 1)) $role_data->Role_Active = 0;
		$role_data['Role_Active'] = 1;
		
		// insert role
		$this->db->insert('roles', $role_data);

		return $this->db->insert_id(); // new role primary key id
	}


}
/* End of file roles_model.php */
/* Location: ./application/models/roles_model.php */