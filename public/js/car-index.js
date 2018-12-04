let confirmCarDelete = (car)=>{
	document.getElementById('delete-car-form').action = "/backend/setting/cars/" + car.id
	let c = confirm('คุณแน่ใจว่าต้องการลบข้อมูล : ' + car.carname);
    if(c){
        event.preventDefault();
        document.getElementById('delete-car-form').submit();
    }else{
        return false;
    }
}

let onClickEditCar = async (id) => {
	let response = await fetch('/backend/setting/cars/'+ id +'/edit');
	let car = await response.json(); //extract JSON from the http response
	await $('#editCar').modal('show');
	document.querySelector('#carname_e').value = car.carname;
	//document.querySelector('#email').value = car.email;
	document.querySelector('#carcolor_e').value = car.carcolor;
	document.querySelector('#status_e').value = car.status;
	document.querySelector('#editCarForm').action = '/backend/setting/cars/' + car.id
	$('#carcolor_e').colorpicker({
		color: car.carcolor,
        format: 'hex'
    });
    
}