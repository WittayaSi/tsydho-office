let confirmUserDelete = (user)=>{
	document.getElementById('delete-user-form').action = "/backend/setting/users/" + user.id
	let c = confirm('คุณแน่ใจว่าต้องการลบข้อมูล : ' + user.name);
    if(c){
        event.preventDefault();
        document.getElementById('delete-user-form').submit();
    }else{
        return false;
    }
}

let onClickEditUser = async (id) => {
	let response = await fetch('/backend/setting/users/'+ id +'/edit');
	let user = await response.json();
	$("#editUser").modal();
	document.querySelector('#name').value = user.name;
	document.querySelector('#color_code_id').value = user.color_code;
	document.querySelector('#user_role').value = user.user_role;
	$('#color_code').colorpicker({
		color: user.color_code,
        format: 'hex'
    });
    document.querySelector('#editForm').action = '/backend/setting/users/' + user.id;
}