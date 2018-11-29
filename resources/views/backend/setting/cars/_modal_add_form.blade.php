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
<div class="modal fade" id="addNewCar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header justify-content-center alert-success">
                <h5 class="modal-title"><i class="fa fa-save"></i> เพิ่ม รถยนต์</h5>
                {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> --}}
            </div>
            <form id="editForm" method="POST" class="needs-validation" novalidate>
                @csrf
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="carname" class="col-md-4 col-form-label text-md-right small-label">เลขทะเบียน</label>

                        <div class="col-md-6">
                            <input id="carname" type="text" 
                                class="form-control{{ $errors->has('carname') ? ' is-invalid' : '' }}" 
                                name="carname" 
                                value="{{ old('carname') }}" 
                                required 
                                autofocus 
                                placeholder="xxx-xxxx-จังหวัด">
                            <div class="invalid-tooltip small-tooltip">
                                ต้องไม่เป็นค่าว่าง
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="carcolor" class="col-md-4 col-form-label text-md-right small-label">สีประจำรถยนต์</label>
                        <div class="col-md-6">
                            <div class="input-group" id="carcolor">
                                <input type="text" class="form-control" 
                                    name="carcolor"
                                    id="carcolor" 
                                    value="{{ old('color_code') ? old('color_code') : '#'.dechex(rand(0,10000000)) }}"
                                    required
                                >
                                <span class="input-group-append">
                                    <span class="input-group-text colorpicker-input-addon"><i></i></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="status" class="col-md-4 col-form-label text-md-right small-label">สถานะการใช้งาน</label>
                        <div class="col-md-6">
                            <select name="status" id="status" class="form-control form-control-sm" required>
                                <option value="active">ยังใช้งานอยู่</option>
                                <option value="inactive">ยกเลิกการใช้งาน</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-sm"><i class="far fa-save"></i> บันทึก</button>
                    <button type="reset" class="btn btn-warning btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> ปิด</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">

$(function () {
    $('#carcolor').colorpicker({
        format: 'hex'
    });
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
