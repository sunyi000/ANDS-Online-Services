<?php 

/**
 * Core Data Source Template File
 * 
 * 
 * @author Minh Duc Nguyen <minh.nguyen@ands.org.au>
 * @see ands/registry_object/_registry_object
 * @package ands/datasource
 * 
 */
?>
<?php $this->load->view('header');?>

<input type="hidden" class="hide" id="ds_id" value="<?php echo $data_source->id;?>"/>

<div class="container" id="main-content">
<div class="modal hide" id="myModal">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">×</button>
    <h3>Alert</h3>
  </div>
  <div class="modal-body"></div>
  <div class="modal-footer">
    
  </div>
</div>
	
<section id="browse-ro">

	<div class="row">
		<div class="box">
			<div class="box-header clearfix">
				<h1><?php echo $data_source->title;?> <small>Manage My Records</small></h1>
				<span class="right-widget">
					<h1><small><?php echo anchor('data_source/#!/view/40', 'Manage This Datasource', array('class'=>'manage_ds_link'));?></small></h1>
				</span>
				<div class="clearfix"></div>
			</div>

			<!-- Toolbar -->
		    <div class="row-fluid" id="mmr_toolbar">
		    	<div class="span4">
		    		<span class="dropdown" id="switch_menu">
		    		<a class="btn dropdown-toggle" data-toggle="dropdown" data-target="#switch_menu" href="#switch_menu">Switch View <span class="caret"></span></a>
					  <ul class="dropdown-menu" id="switch_view">
					    <li><a href="javascript:;" name="thumbnails"><i class="icon-th"></i> Thumbnails View</a></li>
					    <li><a href="javascript:;" name="lists"><i class="icon-th-list"></i> List View</a></li>
					  </ul>
					</span>
					<a class="btn" id="filter">Filter</a>
				</div>
				<div class="span4 centered">
					<span>
						<form class="form-search" id="search-records">
						  <input type="text" class="input-medium" placeholder="Search..." name="list_title">
						  <button class="btn btn-primary">Search</button>
						</form>
					</span>
				</div>
		    	<div class="span4 right-aligned">
		    		<span class="btn-toolbar">
		    			<div class="btn-group">
						  <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
						    Batch
						    <span class="caret"></span>
						  </a>
						  <ul class="dropdown-menu pull-right" id="switch_view">
						    <li><a href="javascript:;" name="thumbnails">Enable Drag and Drop Select</a></li>
						  </ul>
						</div>
			    		<div class="btn-group">
						  <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
						    Options
						    <span class="caret"></span>
						  </a>
						  <ul class="dropdown-menu pull-right" id="switch_view">
						    <li><a href="javascript:;" name="thumbnails">Enable Drag and Drop Select</a></li>
						    <li><a href="javascript:;" name="thumbnails">Hide minibar</a></li>
						  </ul>
						</div>
					</span>
		    	</div>
		    </div>

		    <!-- Middle bar for filtering and item display -->
		    <div class="row-fluid hide" id="filter_fields">
		    	<div class="span12">
		    		<div class="span3">
		    			<h4>Sort</h4>
		    			<ul>
		    				<li><a href="">Date Modified</a></li>
		    				<li><a href="">Quality Level</a></li>
		    				<li><a href="">Title</a></li>
		    			</ul>
		    		</div>
		    		<div class="span3">
		    			Class
		    		</div>
		    		<div class="span3">
		    			Status
		    		</div>
		    		<div class="span3">
		    			Quality level
		    		</div>
		    	</div>
	    		<div class="span12">
	    			<a class="btn">Add Custom Filter</a>
	    		</div>
		    </div>

		    <!-- List of items will be displayed here, in this ul -->
			 	<ul class="lists" id="items"></ul>

			<!-- Load More Link -->
			<div class="row-fluid">
				<div class="span12">
					<div class="well"><a href="javascript:;" id="load_more" page="1">Show More...</a></div>
				</div>
			</div>
</div>
	</div>

</section>
</div><!-- end main content container -->

<section id="view-ro" class="hide">Loading...</section>
<section id="edit-ro" class="hide">Loading...</section>
<section id="expand-ro" class="hide">Loading...</section>
<section id="delete-ro" class="hide">Loading...</section>


<!-- template section -->
<section class="hide" id="ro-templates">
<div class="hide" id="items-template">
	{{#items}}
		<li class="span4">
		  	<div class="item" ro_id="{{id}}">
		  		<div class="item-info status_{{status}}"></div>
		  		<div class="item-snippet">
			  		<h3><small>{{class}}</small> {{list_title}} <small>{{status}}</small></h3>
			  		<p>Last Modified: {{date_modified}} by {{last_modified_by}}</p>
			  		<p>{{last_modified_by}}{{quality_level}}{{flag}}</p>
			  	</div>
		  		<div class="btn-group item-control">
		  			<button class="btn view"><i class="icon-eye-open"></i></button>
			  		<button class="btn edit"><i class="icon-edit"></i></button>
			  		<button class="btn delete"><i class="icon-trash"></i></button>
				</div>
		  	</div>
		  </li>
	{{/items}}
</div>
</section>
<!-- end template section-->
<?php $this->load->view('footer');?>