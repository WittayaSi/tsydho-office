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
<div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header justify-content-center alert-success">
                <h5 class="modal-title"><i class="fa fa-save"></i> แก้ไข User</h5>
                {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> --}}
            </div>
            <form id="editForm" method="POST" class="needs-validation" novalidate>
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right small-label">ชื่อ - สกุล</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus placeholder="ชื่อ - นามสกุล">
                            <div class="invalid-tooltip small-tooltip">
                                ต้องไม่เป็นค่าว่าง
                            </div>
                        </div>
                    </div>

                    {{-- <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right small-label">{{ __('E-Mail') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required placeholder="example@example.com">

                            <div class="invalid-tooltip small-tooltip">
                                ต้องไม่เป็นค่าว่าง
                            </div>
                        </div>
                    </div> --}}
                    
                    <div class="form-group row">
                        <label for="color_code" class="col-md-4 col-form-label text-md-right small-label">สีประจำตัว</label>
                        <div class="col-md-6">
                            <div class="input-group" id="color_code">
                                <input type="text" class="form-control" 
                                    name="color_code"
                                    id="color_code_id" 
                                    required
                                >
                                <span class="input-group-append">
                                    <span class="input-group-text colorpicker-input-addon"><i></i></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="user_role" class="col-md-4 col-form-label text-md-right small-label">ระดับผู้ใช้งาน</label>
                        <div class="col-md-6">
                            <select name="user_role" id="user_role" class="form-control form-control-sm" required>
                                <option value="">ระดับผู้ใช้งาน</option>
                                <option value="admin">admin</option>
                                <option value="guest">guest</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-sm"><i class="far fa-save"></i> แก้ไข</button>
                    <button type="reset" class="btn btn-warning btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> ปิด</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">

// $(function () {
//     $('#color_code').colorpicker({

//         format: 'hex'
//     });
// });

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
