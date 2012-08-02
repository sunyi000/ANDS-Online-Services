<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Core Data Sources model
 * 
 * XXX:
 * 
 * @author Ben Greenwood <ben.greenwood@ands.org.au>
 * @package ands/registryobject
 * 
 */

class Registry_objects extends CI_Model {
		
	public $valid_classes = array("collection","activity","party","service");
	public $valid_status  = array("DRAFT"=>"DRAFT", "PUBLISHED"=>"PUBLISHED", "APPROVED"=>"APPROVED", "SUBMITTED_FOR_ASSESSMENT"=>"SUBMITTED_FOR_ASSESSMENT");
	public $valid_levels  = array("level_1"=>"1", "level_2"=>"2", "level_3"=>"3", "level_4"=>"4" );
	
	
	/**
	 * Returns exactly one data source by Key (or NULL)
	 * 
	 * @param the data source key
	 * @return _data_source object or NULL
	 */
	function getByKey($key)
	{
		$query = $this->db->select("registry_object_id")->get_where('registry_objects', array('key'=>$key));
		if ($query->num_rows() == 0)
		{
			$query->free_result();
			return NULL;
		}
		else
		{
			$id = $query->result_array();
			$query->free_result();
			return new _registry_object($id[0]['registry_object_id']);
		}
	} 	
	
	/**
	 * Returns exactly one data source by Key (or NULL)
	 * 
	 * @param the data source key
	 * @return _data_source object or NULL
	 */
	function getByID($id)
	{
		return new _registry_object($id);
	} 	
	
	
	/**
	 * Returns exactly one data source by URL slug (or NULL)
	 * 
	 * @param the data source slug
	 * @return _data_source object or NULL
	 */
	function getBySlug($slug)
	{
		$query = $this->db->select("registry_object_id")->get_where('registry_objects', array('slug'=>$slug));
		if ($query->num_rows() == 0)
		{
			$query->free_result();
			return NULL;
		}
		else
		{
			$id = $query->result_array();
			$query->free_result();
			return new _registry_object($id[0]['registry_object_id']);
		}
	} 	
	
	
	/**
	 * Get a number of registry_objects that match the attribute requirement (or an empty array)
	 * 
	 * @param the name of the attribute to match by
	 * @param the value that the attribute must match
	 * @return array(_registry_object)
	 */
	function getByAttribute($attribute_name, $value, $core = FALSE)
	{
		$matches = array();
		$this->db->save_queries = FALSE;
		if ($core)
		{
			$query = $this->db->select("registry_object_id")->get_where('registry_objects', array($attribute_name=>$value));
		}
		else
		{
			$query = $this->db->select("registry_object_id")->get_where('registry_object_attributes', array("attribute"=>$attribute_name, "value"=>$value));
		}
		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() AS $result)
			{
				$matches[] = new _registry_object($result['registry_object_id']);
			}
		}
		$query->free_result();
		//var_dump($matches);
		return $matches;
	} 	
	
	/**
	 * Get a number of registry_objects that match the attribute requirement (or an empty array)
	 * 
	 * @param the data source ID to match by
	 * @return array(_registry_object)
	 */
	function getIDsByDataSourceID($data_source_id)
	{
		$matches = array();
		$query = $this->db->select("registry_object_id")->get_where('registry_objects', array("data_source_id"=>$data_source_id));
		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() AS $result)
			{
				$matches[] = $result['registry_object_id'];
			}
		}
		$query->free_result();
		return $matches;
	} 	

	/**
	 * Get a number of registry_objects that match the attribute requirement (or an empty array)
	 * 
	 * @param the data source ID to match by
	 * @return array(_registry_object)
	 */
	function getByDataSourceKey($data_source_key)
	{
		$matches = array();
		$query = $this->db->select("registry_object_id")->join('data_sources', 'data_sources.data_source_id = registry_objects.data_source_id')->get_where('registry_objects', array("data_sources.key"=>$data_source_key));
		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() AS $result)
			{
				$matches[] = new _registry_object($result['registry_object_id']);
			}
		}
		$query->free_result();
		return $matches;
	} 	
	
	
	/**
	 * XXX: 
	 * @return array(_data_source) or NULL
	 */
	function create($data_source_key, $registry_object_key, $class, $title, $status, $slug, $record_owner)
	{
		if (is_null($this->getByKey($registry_object_key)))
		{
			
			$ro = new _registry_object();
			
			// Get the data_source_id for this data source key		
			$this->load->model('data_source/data_sources','ds');
			$ds = $this->ds->getByKey($data_source_key);
			$ro->_initAttribute("data_source_id", $ds->getAttribute('data_source_id'), TRUE);
	
	
			$ro->_initAttribute("key",$registry_object_key, TRUE);
			$ro->_initAttribute("class",$class, TRUE);
			$ro->_initAttribute("title",$title, TRUE);
			$ro->_initAttribute("status",$status, TRUE);
			$ro->_initAttribute("slug",$slug, TRUE);
			$ro->_initAttribute("record_owner",$record_owner, TRUE);
			
			// Some extras
			$ro->setAttribute("created",time());
	
			$ro->create();
			return $ro;
			
		}
		else
		{
			return $this->update($registry_object_key, $class, $title, $status, $slug, $record_owner);
		}
	} 	
	
	/**
	 * XXX: 
	 * @return array(_data_source) or NULL
	 */
	function update($registry_object_key, $class, $title, $status, $slug, $record_owner)
	{
		$ro = $this->getByKey($registry_object_key);
		if (!is_null($ro))
		{

			$ro->setAttribute("class",$class);
			$ro->setAttribute("title",$title);
			$ro->setAttribute("status",$status);
			$ro->setAttribute("slug",$slug);
			$ro->setAttribute("record_owner",$record_owner);

			$ro->save();		
			return $ro;	
		}
		else
		{
			throw new Exception ("Unable to update registry object (this registry object key does not exist in the registry)");	
		}
	} 	
	
	
	
	/**
	 * @ignore
	 */
	function __construct()
	{
		parent::__construct();
		include_once("_registry_object.php");
	}	
		
}
