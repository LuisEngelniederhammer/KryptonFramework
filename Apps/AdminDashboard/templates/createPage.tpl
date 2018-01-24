<!--
AdminDashboard Widget (c) 2017 Luis Engelniederhammer
createPage.tpl
 -->
<table class="table table-striped table-hover">
    <tbody>
		<form onsubmit="return confirm('Confirm your changes');" method="POST" action="{{POST_ACTION}}">
			<tr class="active">
				<td>name</td>
				<td><input type="text" name="page_name" placeholder="page name" class="col-10"></td>
			</tr>
			<tr class="active">
				<td>content</td>
				<td><textarea name="page_content" class="col-10" rows="10" placeholder="page content"></textarea></td>
			</tr>
			<tr class="active">
				<td>roles</td>
				<td><input type="text" name="page_roles" class="col-10" placeholder="page permissions/roles"></td>
			</tr>
			<tr  class="active">
				<td colspan="2">
					<a href="{{LINK}}" class="btn">Back</a>
					<input class="btn" type="submit" name="page_create" value="Save">
				</td>
			</tr>
		</form>
    </tbody>
</table>