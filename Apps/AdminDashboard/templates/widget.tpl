<!--
AdminDashboard Widget (c) 2017 Luis Engelniederhammer
widget.tpl
 -->
<div class="columns">
	<div class="col-12">
		<div class="btn-group btn-group-block">
			<a href="{{LINK_PAGES}}" class="btn btn-primary {{ACTIVE_PAGES}}">Pages</a>
          	<a href="{{LINK_USERS}}" class="btn btn-primary {{ACTIVE_USERS}}">Users</a>
          	<a href="{{LINK_SYSTEM}}" class="btn btn-primary {{ACTIVE_SYSTEM}}">System</a>
          	<a href="{{LINK_ROLES}}" class="btn btn-primary {{ACTIVE_ROLES}}">Roles</a>
          	<a href="{{LINK_APPS}}" class="btn btn-primary {{ACTIVE_APPS}}">Apps</a>
		</div>
	</div>
        
	<div class="col-12">{{CONTENT}}</div>
</div>
          
       
        