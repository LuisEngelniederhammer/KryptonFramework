<table class="table table-striped table-hover">
    <tbody>
		<form onsubmit="return confirm('Confirm your changes');" method="POST" action="{{POST_ACTION}}">
			<tr class="active">
				<td>ID</td>
				<td>{{ID}}</td>
			</tr>
			<tr class="active">
				<td>name</td>
				<td><input type="text" name="user_name" value="{{NAME}}" class="col-10"></td>
			</tr>
			<tr class="active">
				<td>password</td>
				<td><input type="text" name="user_password" value="{{PASSWORD}}" class="col-10"></td>
			</tr>
			<tr class="active">
				<td>roles</td>
				<td><input type="text" name="user_role" value="{{ROLE}}"></td>
			</tr>
			<tr>
				<td colspan="2">
					<a href="{{LINK}}" class="btn">Back</a>
					<input class="btn" type="submit" name="user_update" value="Save">
					<input class="btn" type="submit" name="user_delete" value="Delete">
				</td>
			</tr>
		</form>
    </tbody>
</table>