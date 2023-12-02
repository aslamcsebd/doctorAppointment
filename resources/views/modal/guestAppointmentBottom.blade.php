
<div class="modal fade" id="viewModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title text-center" id="exampleModalLabel">Appointment information</h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
			</div>
			<div class="modal-body">
				<div class="card">
					<div class="card-body row justify-content-center p-1">
						<div class="col-4">
							<div class="border border-primary rounded px-1">
								<table class="table table-bordered">
									<tbody>
										<tr>
											<td><b>Doctor information</b></td>
										</tr>
										<tr>
											<td>
												<img id="picture" src="" class="img-thumbnail">
												<br>
												<span id="doctor_name"></span>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-8">
							<div class="border border-primary rounded p-1">
								<table class="table table-bordered mb-0">
									<tbody>
										<tr>
											<td colspan="2"><b>Patient information</b></td>
										</tr>												
										<?php 
											$fields = array("name", "email", "phone", "age", "appointment_date", "diseases_info", "address", "source", "status");
											foreach ($fields as $field) { ?>		
												<tr>
													<td width="30%">
														<b><?=$field?></b>
													</td>
													<td id="<?=$field?>"></td>
												</tr>
										<?php } ?>												
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div class="btn-group">
						<button class="btn btn-outline-secondary" type="button" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
