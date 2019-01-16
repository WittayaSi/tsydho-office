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
<div class="modal fade" id="addTask" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header justify-content-center alert-success">
                <h5 class="modal-title"><i class="fa fa-save"></i> เพิ่มแผนปฏิบัติงาน</h5>
                {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> --}}
            </div>
            <form method="POST" action="/frontend/tasks" class="needs-validation" novalidate>
                @csrf
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col">
                            <label for="task" class="small-label">เรื่อง</label>
                            <input type="text" class="form-control form-control-sm" name="task" id="task" placeholder="เรื่อง" 
                                value="{{ old('task') }}"
                                pattern="[ ^ ]{2,100}"
                                required 
                            >
                            <div class="invalid-tooltip small-tooltip">
                                ต้องไม่เป็นค่าว่าง และไม่เกิน 100 ตัวอักษร
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <label for="description" class="small-label">รายละเอียด</label>
                            <textarea class="form-control form-control-sm" name="description" id="description" 
                                placeholder="รายละเอียด" 
                                rows="7" 
                                required
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
                                    id="start_date" 
                                    value="{{ old('start_date') }}" 
                                    required
                                    onchange="
                                        document.querySelector('#end_date').min = this.value;
                                        document.querySelector('#end_date').value = this.value;
                                        document.querySelector('#end_date').disabled = false;
                                        document.querySelector('#settingcar_id').disabled = false;
                                        document.querySelector('#settingcar_id').value = '';
                                    "
                                >
                            </div>
                        </div>
                        <div class='col'>
                            <label class="small-label">&nbsp</label>
                            <div class="input-group date">
                                <input type="date" class="form-control form-control-sm" name="end_date" id="end_date" 
                                    value="{{ old('end_date') }}" 
                                    required
                                    disabled
                                    onchange="
                                        document.querySelector('#settingcar_id').value = '';
                                    "
                                >
                            </div>
                        </div>
                    </div>

                    
                    <button type="button" class="btn btn-primary btn-sm add-car-button" style="margin-top: 20px;"
                        onclick="addCarForm();" 
                    >ต้องการใช้รถยนต์</button>

                    <div class="form-row add-car-form" style="display: none;">
                        <div class="col-md-6">
                                <label for="settingcar_id" class="small-label">ทะเบียน</label>
                                <select class="form-control form-control-sm" name="settingcar_id" id="settingcar_id"
                                    onchange="checkCarIsAlready(this)"
                                    disabled 
                                >
                                    <option value="">เลือกรถยนต์</option>
                                    @foreach($data['settingcars'] as $car)
                                        <option value="{{ $car->id }}"
                                            {{ old('settingcar_id') == $car->id ? 'selected' : '' }}
                                        >
                                            {{ $car->carname }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                    </div>
                </div>

                @include('frontend.tasks.errors')

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-sm" id="addTaskBT"><i class="far fa-save"></i> เพิ่ม</button>
                    <button type="reset" class="btn btn-warning btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> ปิด</button>
                </div>
            </form>

            {{-- <form id="check-car-form" method="POST" style="display: none;">
                @csrf
                <input type="hidden" name="check_start_date" id="check_start_date">
                <input type="hidden" name="check_end_date" id="check_end_date">
            </form> --}}
        </div>
    </div>
</div>
<script type="text/javascript">

let checkCarIsAlready = (selected)=>{
    let start = document.querySelector('#start_date').value;
    let end = document.querySelector('#end_date').value;
    console.log(start, end, selected.value)
    axios.post('/customer-api/check-car',{
            car_id: selected.value,
            start_date: start,
            end_date: end
        }).then((res)=>{
            console.log(res.data);
        if(res.data.status === 'err'){
            document.querySelector("#check-car-error").style.display = "";
            document.querySelector("#settingcar_id").value = "";
            document.querySelector("#message-error").innerHTML = res.data.message;
            document.querySelector("#addTaskBT").disabled = true
        }else{
            document.querySelector("#message-error").innerHTML ="";
            document.querySelector("#check-car-error").style.display = "none";
            document.querySelector("#addTaskBT").disabled = false
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

$('#addTask').on('hidden.bs.modal', function(){
    $(this).find('form')[0].reset();
});

let addCarForm = ()=>{
    let div = document.querySelector('.add-car-form');
    let car_selector = document.querySelector('#settingcar_id');
    if(div.style.display === "none"){
        div.style.display = "block";
    }else{
        car_selector.value ="";
        div.style.display = "none";
    }
}

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
