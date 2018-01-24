<!--
AdminDashboard Widget (c) 2017 Luis Engelniederhammer
createUser.tpl
 -->
<table class="table table-striped table-hover">
    <tbody>
		<form onsubmit="return confirm('Confirm your changes');" method="POST" action="{{POST_ACTION}}">
			<tr class="active">
				<td>name</td>
				<td><input type="text" name="user_name" placeholder="user name" class="col-10" required></td>
			</tr>
			<tr class="active">
				<td>password</td>
				<td><input type="password" name="user_password" placeholder="user password" class="col-10" required></td>
			</tr>
			<tr class="active">
				<td>roles</td>
				<td><input type="text" name="user_role" class="col-10" placeholder="user role" required></td>
			</tr>
			<tr  class="active">
				<td colspan="2">
					<a href="{{LINK}}" class="btn">Back</a>
					<input class="btn" type="submit" name="user_create" value="Save">
				</td>
			</tr>
		</form>
    </tbody>
</table>