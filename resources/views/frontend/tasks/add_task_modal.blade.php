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
                                pattern="[ a-zA-Z0-9\u0E00-\u0E7F]{2,100}"
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
                                    {{-- 
                                    onchange="
                                        document.querySelector('#start_date').value = this.value;
                                    " --}}
                                >
                            </div>
                        </div>
                    </div>
                </div>
                @include('frontend.tasks.errors')
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-sm"><i class="far fa-save"></i> เพิ่ม</button>
                    <button type="reset" class="btn btn-warning btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> ปิด</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">

$('#addTask').on('hidden.bs.modal', function(){
    $(this).find('form')[0].reset();
});

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
