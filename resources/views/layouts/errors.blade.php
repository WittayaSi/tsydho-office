@if($errors->any())
	<div class="alert alert-danger text-center" id="admin-error">
		<h4>{{$errors->first()}}</h4>
	</div>
@endif

<script type="text/javascript">
setTimeout(()=>{
	document.querySelector('#admin-error').style.display = 'none';
}, 3000);
</script>