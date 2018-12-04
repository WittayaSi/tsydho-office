<!-- Modal -->
<style type="text/css">
.small-label {
    font-size: .8rem;
}

.small-tooltip {
    font-size: .6rem;
    margin-top: -0.9rem;
}

input[type=date]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    display: none;
}

input::placeholder,
textarea::placeholder,
option,
.select-style {
    font-size: 0.8rem;
}

</style>
<div class="modal fade" id="detailTask" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header justify-content-center alert-primary">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-list-alt"></i> รายละเอียด</h5>
                {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> --}}
            </div>
            <form id="form-detail" method="POST" class="needs-validation" novalidate>
                @csrf
                @method('PATCH')
                <input type="hidden" name="task_id">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col">
                            <label for="task" class="small-label">เรื่อง</label>
                            <input type="text" class="form-control form-control-sm" name="task" id="task-s" 
                                placeholder="เรื่อง" 
                                value="{{ old('task') }}"
                                {{-- pattern="[\u0E00-\u0E7F 0-9a-zA-Z]{2,100}" --}}
                                required
                                disabled
                            >
                            <div class="invalid-tooltip small-tooltip">
                                ต้องไม่เป็นค่าว่าง และต้องเป็นภาษาไทย
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <label for="description" class="small-label">รายละเอียด</label>
                            <textarea class="form-control form-control-sm" name="description" id="description-s" 
                                placeholder="รายละเอียด"
                                rows="7" 
                                required
                                disabled
                            >{{ old('description') }}</textarea>
                            <div class="invalid-tooltip small-tooltip">
                                ต้องไม่เป็นค่าว่าง
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class='col'>
                            <label class="small-label">ระหว่างวันที่</label>
                            <div class="input-group date">
                                <input type="date" class="form-control form-control-sm" 
                                    name="start_date" 
                                    id="start_date_s" 
                                    value="{{ old('start_date') }}" 
                                    required
                                    disabled
                                    onchange="
                                        document.querySelector('#end_date_s').min = this.value;
                                        document.querySelector('#end_date_s').value = this.value;
                                        document.querySelector('#settingcar_id_s').value = '';
                                    "
                                >
                            </div>
                        </div>
                        <div class='col'>
                            <label class="small-label">&nbsp</label>
                            <div class="input-group date">
                                <input type="date" class="form-control form-control-sm" name="end_date" id="end_date_s"
                                    value="{{ old('end_date') }}" 
                                    required
                                    disabled
                                    onchange="
                                        document.querySelector('#settingcar_id_s').value = '';
                                    "
                                >
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="user_id">
                    <input type="hidden" id="task_id" name="task_id">

                    <button type="button" class="btn btn-primary btn-sm edit-car-button" style="margin-top: 20px;"
                        onclick="editCarForm();" 
                        id="edit-car-button"
                        disabled
                    >มีการใช้รถยนต์</button>

                    <div class="form-row edit-car-form" id="edit-car-form" style="display: none;">
                        <div class="col-md-6">
                                <label for="settingcar_id_s" class="small-label">ทะเบียน</label>
                                <select class="form-control form-control-sm" name="settingcar_id" id="settingcar_id_s"
                                    onchange="checkCarIsAlreadyEditForm(this)"
                                    disabled 
                                >
                                    <option value="">เลือกรถยนต์</option>
                                    @foreach($data['settingcars'] as $car)
                                        <option value="{{ $car->id }}"
                                        >
                                            {{ $car->carname }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                    </div>
                </div>

                {{-- error block --}}
                <div id="check-car-error-edit-form" style="display: none">
                    <div class="alert alert-danger">
                        <ul>
                                <li id="message-error-edit-form">
                                </li>
                        </ul>
                    </div>
                </div>
                {{-- error block --}}

                <div class="modal-footer">
                    <div id="owner_group" style="display: none;" class="text-left">
                        <button type="submit" class="btn btn-success btn-sm" id="edit-form-confirm" style="display: none;"><i class="far fa-save"></i> ยืนยันแก้ไข</button>
                        <button type="button" class="btn btn-primary btn-sm" id="edit-form" onclick="enableForm();"><i class="fa fa-edit"></i>แก้ไข</button>
                        <button type="button" class="btn btn-danger btn-sm" 
                            onclick="confirmDelete();"
                        ><i class="fa fa-trash-alt"></i> ลบ</button>
                    </div>
                    <button type="button" class="btn btn-warning btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> ปิด</button>
                </div>
            </form>
            <form id="delete-form" method="POST" style="display: none;">
                @method('DELETE')
                @csrf
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
let task_s = document.querySelector('#task-s');
let description_s = document.querySelector('#description-s');
let start_date_s = document.querySelector('#start_date_s');
let end_date_s = document.querySelector('#end_date_s');
let owner_group = document.querySelector('#owner_group');
let edit_form_confirm = document.querySelector('#edit-form-confirm');
let edit_form = document.querySelector('#edit-form');
let edit_car_button = document.querySelector('#edit-car-button');
let settingcar_id_s = document.querySelector('#settingcar_id_s');
let edit_car_form = document.querySelector("#edit-car-form");
let error_edit_form = document.querySelector("#error-edit-form");


let checkCarIsAlreadyEditForm = (selected)=>{
    //let start = document.querySelector('#start_date').value;
    //let end = document.querySelector('#end_date').value;
    axios.post('/customer-api/check-car',{
            car_id: selected.value,
            start_date: start_date_s.value,
            end_date: end_date_s.value,
            task_id: document.querySelector('#task_id').value
        }).then((res)=>{
            console.log(res.data)
        if(res.data.status === 'err'){
            document.querySelector("#check-car-error-edit-form").style.display = "";
            document.querySelector("#settingcar_id_s").value = "";
            document.querySelector("#message-error-edit-form").innerHTML = res.data.message;
        }else{
            document.querySelector("#message-error-edit-form").innerHTML ="";
            document.querySelector("#check-car-error-edit-form").style.display = "none";
        }
    }).catch((err)=>{
        console.log(err);
    })
    // event.preventDefault();
    // document.querySelector('#check_start_date').value = start;
    // document.querySelector('#check_end_date').value = end;
    // document.getElementById('check-car-form').action = '/frontend/tasks/check-car/' + selected.value;
    // document.getElementById('check-car-form').submit();

}

let confirmDelete = ()=>{
    let c = confirm('คุณแน่ใจว่าต้องการลบข้อมูลนี้!!!');
    if(c){
        event.preventDefault();
        document.getElementById('delete-form').submit();
    }else{
        return false;
    }
}

let editCarForm = ()=>{
    if(edit_car_form.style.display === "none"){
        edit_car_form.style.display = "block";
    }else{
        settingcar_id_s.value ="";
        edit_car_form.style.display = "none";
    }
}

$('#detailTask').on('hidden.bs.modal', function(){
    //location.reload();
    task_s.disabled = !false;
    description_s.disabled = !false;
    start_date_s.disabled = !false;
    end_date_s.disabled = !false;
    edit_car_button.disabled = !false;
    settingcar_id_s.disabled = !false;
    owner_group.style.display = 'none';
    edit_form_confirm.style.display = 'none';
    edit_form.style.display = '';
    edit_car_form.style.display = "none";

});
let enableForm = (input)=>{
    task_s.disabled = false;
    description_s.disabled = false;
    start_date_s.disabled = false;
    end_date_s.disabled = false;
    edit_car_button.disabled = false;
    settingcar_id_s.disabled = false;
    edit_form.style.display = 'none';
    edit_form_confirm.style.display = '';

}

$('#detailTask').on('shown.bs.modal', ()=>{
    //console.log('{{ auth()->user()->user_role }}');
    console.log(settingcar_id_s.value);
    
    let auth_id = {{ auth()->id() }};
    let admin = '{{ auth()->user()->user_role }}';
    let user_id = document.querySelector("#user_id").value;
    (auth_id == user_id) || (admin == 'admin') ? owner_group.style.display = '' : owner_group.style.display = 'none';
    if(settingcar_id_s.value != ""){
        edit_car_form.style.display = ""
    }

})



(
    function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    }
)();
</script>