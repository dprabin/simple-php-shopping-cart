<!--    <div class="panel-body">-->
<?php echo form_open( base_url( 'search' ), 'id="search_sam" class="navbar-form navbar-left"' ); ?>

<fieldset id="filter-bar" class="form-group">
    <div class="filter-search fltlft">

        <input type="text" class="form-control" name="s" id="filter_search" value="<?php echo @$edit_data[ 's' ]; ?>"
               title="Search">
        <button type="submit" class="btn btn-default">Search</button>
    </div>
</fieldset>
<?php echo form_close(); ?>
