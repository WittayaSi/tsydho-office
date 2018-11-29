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
                                        document.querySelector('#start_date_s').value = this.value;
                                    "
                                >
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="user_id">
                </div>
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

let confirmDelete = ()=>{
    let c = confirm('คุณแน่ใจว่าต้องการลบข้อมูลนี้!!!');
    if(c){
        event.preventDefault();
        document.getElementById('delete-form').submit();
    }else{
        return false;
    }
}

$('#detailTask').on('hidden.bs.modal', function(){
    //location.reload();
    task_s.disabled = !false;
    description_s.disabled = !false;
    start_date_s.disabled = !false;
    end_date_s.disabled = !false;
    owner_group.style.display = 'none';
    edit_form_confirm.style.display = 'none';
    edit_form.style.display = '';
});
let enableForm = (input)=>{
    task_s.disabled = false;
    description_s.disabled = false;
    start_date_s.disabled = false;
    end_date_s.disabled = false;
    edit_form.style.display = 'none';
    edit_form_confirm.style.display = '';
}

$('#detailTask').on('shown.bs.modal', ()=>{
    //console.log('{{ auth()->user()->user_role }}');
    let auth_id = {{ auth()->id() }};
    let admin = '{{ auth()->user()->user_role }}';
    let user_id = document.querySelector("#user_id").value;
    (auth_id == user_id) || (admin == 'admin') ? owner_group.style.display = '' : owner_group.style.display = 'none';

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