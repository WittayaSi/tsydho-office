    <div class="modal fade" id="detailCarUse" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header justify-content-center alert-primary">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-list-alt"></i> รายละเอียด</h5>
                    {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> --}}
                </div>
                <form id="editCarUseForm" method="POST" class="needs-validation" novalidate>
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="col">
                                <label for="settingcar_id" class="small-label">ทะเบียน</label>
                                <select class="form-control form-control-sm" name="settingcar_id" id="settingcar_id_e" required disabled>
                                    <option value="">เลือกรถยนต์</option>
                                    @foreach($data['settingcars'] as $car)
                                        <option value="{{ $car->id }}"
                                            {{ old('settingcar_id') == $car->id ? 'selected' : '' }}
                                        >{{ $car->carname }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-tooltip small-tooltip">
                                    ต้องไม่เป็นค่าว่าง
                                </div>
                            </div>
                            <div class="col-md-9">
                                <label for="title" class="small-label">เรื่อง</label>
                                <input type="text" class="form-control form-control-sm" name="title" id="title_e" placeholder="เรื่อง" 
                                    value="{{ old('title') }}"
                                    pattern="[^]{2,100}"
                                    required 
                                    disabled
                                >
                                <div class="invalid-tooltip small-tooltip">
                                    ต้องไม่เป็นค่าว่าง 2-100 ตัวอักษร
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <label for="description" class="small-label">รายละเอียด</label>
                                <textarea class="form-control form-control-sm" name="description" id="description_e" 
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
                                        id="start_date_e" 
                                        value="{{ old('start_date') }}" 
                                        required
                                        disabled
                                        onchange="
                                            document.querySelector('#end_date_e').min = this.value;
                                            document.querySelector('#end_date_e').value = this.value;
                                            //document.querySelector('#end_date_e').disabled = false;
                                        "
                                    >
                                </div>
                            </div>
                            <div class='col'>
                                <label class="small-label">&nbsp</label>
                                <div class="input-group date">
                                    <input type="date" class="form-control form-control-sm" 
                                        name="end_date" 
                                        id="end_date_e" 
                                        value="{{ old('end_date') }}" 
                                        required
                                        disabled
                                    >
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="user_id" name="user_id" value={{ old('user_id') }}>
                    </div>
                    @include('frontend.car-uses.errors')
                    <div class="modal-footer">
                        <div id="owner_group" style="display: none;" class="text-left">
                            <button type="submit" class="btn btn-success btn-sm" id="edit-car-form-confirm" style="display: none;"><i class="far fa-save"></i> ยืนยันแก้ไข</button>
                            <button type="button" class="btn btn-primary btn-sm" id="edit-car-form" 
                                onclick="enableForm()"><i class="fa fa-edit"></i>แก้ไข</button>
                            <button type="button" class="btn btn-danger btn-sm" 
                                onclick="confirmDelete();"
                            ><i class="fa fa-trash-alt"></i> ลบ</button>
                        </div>
                        <button type="button" class="btn btn-warning btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> ปิด</button>
                    </div>
                </form>
                <form id="delete-car-use-form" method="POST" style="display: none;">
                    @method('DELETE')
                    @csrf
                </form>
            </div>
        </div>
    </div>

<script type="text/javascript">
let settingcar_id_e = document.querySelector('#settingcar_id_e');
let title_e = document.querySelector('#title_e');
let description_e = document.querySelector('#description_e');
let start_date_e = document.querySelector('#start_date_e');
let end_date_e = document.querySelector('#end_date_e');
let owner_group = document.querySelector('#owner_group');
let edit_form_confirm = document.querySelector('#edit-car-form-confirm');
let edit_form = document.querySelector('#edit-car-form');

let confirmDelete = ()=>{
    let c = confirm('คุณแน่ใจว่าต้องการลบข้อมูลนี้!!!');
    if(c){
        event.preventDefault();
        document.getElementById('delete-car-use-form').submit();
    }else{
        return false;
    }
}

let disableForm = ()=>{
    settingcar_id_e.disabled = !false;
    title_e.disabled = !false;
    description_e.disabled = !false;
    start_date_e.disabled = !false;
    end_date_e.disabled = !false;
    //owner_group.style.display = 'none';
    edit_form_confirm.style.display = 'none';
    edit_form.style.display = '';
}
let enableForm = (input)=>{
    //input.style.display = 'none';
    settingcar_id_e.disabled = false;
    title_e.disabled = false;
    description_e.disabled = false;
    start_date_e.disabled = false;
    end_date_e.disabled = false;
    edit_form.style.display = 'none';
    edit_form_confirm.style.display = '';
}

let adminOrOwner = ()=>{
    //console.log(from);
    let auth_id = {{ auth()->id() }};
    let admin = '{{ auth()->user()->user_role }}';
    let user_id = document.querySelector("#user_id").value;
    (auth_id == user_id) || (admin == 'admin') ? owner_group.style.display = '' : owner_group.style.display = 'none';
}

$('#detailCarUse').on('hidden.bs.modal', function(){
    //location.reload();
    disableForm();
});

$('#detailCarUse').on('shown.bs.modal', ()=>{
    adminOrOwner();
    @if($errors->has('update_errors'))
        enableForm();
        adminOrOwner();
        console.log('do somthing when update errors');
    @endif
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