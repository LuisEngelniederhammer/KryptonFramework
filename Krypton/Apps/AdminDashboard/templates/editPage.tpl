<style>


tr {
    border-bottom: 1px solid #ddd;
    background-color: #fff;
}

</style>
<table class="table table-hover">
<!--<thead>
		<tr>
			<th></th>
            <th></th>
        </tr>
    </thead>-->
	<form onsubmit="return confirm('Confirm your changes');" method="POST" action="{{POST_ACTION}}">
    <tbody>
			<tr>
				<td>ID</td>
				<td>{{ID}}</td>
			</tr>
			<tr>
				<td>name</td>
				<td><input type="text" name="page_name" value="{{NAME}}" class="col-10"></td>
			</tr>
			<tr>
				<td>content</td>
				<td><textarea name="page_content" class="col-10" rows="10">{{CONTENT}}</textarea></td>
			</tr>
			<tr>
				<td>roles</td>
				<td><input type="text" name="page_roles" value="{{ROLES}}"></td>
			</tr>
			<tr>
				<td colspan="2">
					<a href="{{LINK}}" class="btn">Back</a>
					<input class="btn" type="submit" name="page_update" value="Save">
					<input class="btn" type="submit" name="page_delete" value="Delete">
				</td>
			</tr>
		
    </tbody>
	</form>
</table>