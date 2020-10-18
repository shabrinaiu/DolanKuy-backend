<!DOCTYPE html>
<html>
<head>
	<title>Tutorial Membuat CRUD Pada Laravel - www.malasngoding.com</title>
</head>
<body>

	<h2>www.malasngoding.com</h2>
	<h3>Data Pegawai</h3>

	<a href=""> + Tambah Pegawai Baru</a>
	
	<br/>
	<br/>

	<table border="1">
		<tr>
			<th>Username</th>
			<th>Name</th>
			<th>Price</th>
			<th>Category_id</th>
		</tr>
		<?php $__currentLoopData = $contoh; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<tr>
			<td><?php echo e($p->username); ?></td>
			<td><?php echo e($p->name); ?></td>
			<td><?php echo e($p->price); ?></td>
			<td><?php echo e($p->category_id); ?></td>
			<td>
				<a href="">Edit</a>
				|
				<a href="">Hapus</a>
			</td>
		</tr>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</table>


</body>
</html><?php /**PATH C:\xampp\htdocs\DolanKuy-backend-1\resources\views/index.blade.php ENDPATH**/ ?>