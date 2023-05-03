<aside class="col-lg-3 column">
	<div class="widget border">
		<h3 class="sb-title closed">Location</h3>
		<div class="specialism_widget">
			<div class="simple-checkbox scrollbar">
				<?php
				$retrieve = "SELECT * FROM states";
				$qery = $conn->prepare($retrieve);
				$qery->execute();
				$results=$qery->fetchAll(PDO::FETCH_OBJ);
				if($qery->rowCount() > 0)
				{
					foreach($results as $fetch)
					{
						$state_id = $fetch->id;
						$count = "SELECT id FROM jobs WHERE status = 1 AND verified = 1 AND state_id = :state_id AND (job_expiry_date > CURDATE())";
						$fetch_id = $conn->prepare($count);
						$fetch_id->bindParam(":state_id", $state_id, PDO::PARAM_INT);
						$fetch_id->execute();
						$cnt = $fetch_id->rowCount();
						echo '
						<p><input type="checkbox" id="1'.$fetch->id.'" class="filter_all states" value="'.$fetch->id.'"><label for="1'.$fetch->id.'">'.$fetch->state.' ('.$cnt.')</label></p>';
					}
				}
				?>
			</div>
		</div>
	</div>
	<div class="widget border">
		<h3 class="sb-title closed">Function</h3>
		<div class="specialism_widget">
			<div class="simple-checkbox scrollbar">
				<?php
				$retrieve = "SELECT * FROM functional_areas WHERE status = 1";
				$qery = $conn->prepare($retrieve);
				$qery->execute();
				$results=$qery->fetchAll(PDO::FETCH_OBJ);
				if($qery->rowCount() > 0)
				{
					foreach($results as $fetch)
					{
						$functional_area_id = $fetch->id;
						$count = "SELECT id FROM jobs WHERE status = 1 AND verified = 1 AND functional_area_id = :functional_area_id AND (job_expiry_date > CURDATE())";
						$fetch_id = $conn->prepare($count);
						$fetch_id->bindParam(":functional_area_id", $functional_area_id, PDO::PARAM_INT);
						$fetch_id->execute();
						$cnt = $fetch_id->rowCount();
						echo '
						<p><input type="checkbox" id="2'.$fetch->id.'" class="filter_all functional_area" value="'.$fetch->id.'"><label for="2'.$fetch->id.'">'.$fetch->functional_area.' ('.$cnt.')</label></p>';
					}
				}
				?>
			</div>
		</div>
	</div>
	<div class="widget border">
		<h3 class="sb-title closed">Experience (In Years)</h3>
		<div class="specialism_widget">
			<div class="simple-checkbox scrollbar">
				<?php
				$retrieve = "SELECT * FROM job_experiences";
				$qery = $conn->prepare($retrieve);
				$qery->execute();
				$results=$qery->fetchAll(PDO::FETCH_OBJ);
				if($qery->rowCount() > 0)
				{
					foreach($results as $fetch)
					{
						$job_experience_id = $fetch->id;
						$count = "SELECT id FROM jobs WHERE status = 1 AND verified = 1 AND job_experience_id = :job_experience_id AND (job_expiry_date > CURDATE())";
						$fetch_id = $conn->prepare($count);
						$fetch_id->bindParam(":job_experience_id", $job_experience_id, PDO::PARAM_INT);
						$fetch_id->execute();
						$cnt = $fetch_id->rowCount();
						echo '
						<p><input type="checkbox" id="3'.$fetch->id.'" class="filter_all experience" value="'.$fetch->id.'"><label for="3'.$fetch->id.'">'.$fetch->job_experience.' ('.$cnt.')</label></p>';
					}
				}
				?>
			</div>
		</div>
	</div>
	<div class="widget border">
		<h3 class="sb-title closed">Salary (INR)</h3>
		<div class="posted_widget">
				<?php
				$count_salary1 = "SELECT id FROM jobs WHERE status = 1 AND verified = 1 AND salary_from >= 0 AND salary_to <= 300000 AND (job_expiry_date > CURDATE())";
				$fetch_id1 = $conn->prepare($count_salary1);
				$fetch_id1->execute();
				$cnt1 = $fetch_id1->rowCount();

				$count_salary2 = "SELECT id FROM jobs WHERE status = 1 AND verified = 1 AND salary_from >= 300000 AND salary_to <= 600000 AND (job_expiry_date > CURDATE())";
				$fetch_id2 = $conn->prepare($count_salary2);
				$fetch_id2->execute();
				$cnt2 = $fetch_id2->rowCount();

				$count_salary3 = "SELECT id FROM jobs WHERE status = 1 AND verified = 1 AND salary_from >= 600000 AND salary_to <= 1000000 AND (job_expiry_date > CURDATE())";
				$fetch_id3 = $conn->prepare($count_salary3);
				$fetch_id3->execute();
				$cnt3 = $fetch_id3->rowCount();

				$count_salary4 = "SELECT id FROM jobs WHERE status = 1 AND verified = 1 AND salary_from >= 1000000 AND salary_to <= 1500000 AND (job_expiry_date > CURDATE())";
				$fetch_id4 = $conn->prepare($count_salary4);
				$fetch_id4->execute();
				$cnt4 = $fetch_id4->rowCount();
				?>
				<input type="radio" id="40" name="salary" class="filter_all salary1" value="1"><label for="40">0-3 Lakhs (<?php echo $cnt1; ?>)</label>
				<input type="radio" id="41" name="salary" class="filter_all salary2" value="2"><label for="41">3-6 Lakhs (<?php echo $cnt2; ?>)</label>
				<input type="radio" id="42" name="salary" class="filter_all salary3" value="3"><label for="42">6-10 Lakhs (<?php echo $cnt3; ?>)</label>
				<input type="radio" id="43" name="salary" class="filter_all salary4" value="4"><label for="43">10-15 Lakhs (<?php echo $cnt4; ?>)</label>
		</div>
	</div>
	<div class="widget border">
		<h3 class="sb-title closed">Qualification</h3>
		<div class="specialism_widget">
			<div class="simple-checkbox scrollbar">
				<?php
				$retrieve = "SELECT * FROM qualifications WHERE status = 1";
				$qery = $conn->prepare($retrieve);
				$qery->execute();
				$results=$qery->fetchAll(PDO::FETCH_OBJ);
				if($qery->rowCount() > 0)
				{
					foreach($results as $fetch)
					{
						$qualification_id = $fetch->id;
						$count = "SELECT id FROM jobs WHERE status = 1 AND verified = 1 AND qualification_id = :qualification_id AND (job_expiry_date > CURDATE())";
						$fetch_id = $conn->prepare($count);
						$fetch_id->bindParam(":qualification_id", $qualification_id, PDO::PARAM_INT);
						$fetch_id->execute();
						$cnt = $fetch_id->rowCount();
						echo '
						<p><input type="checkbox" id="5'.$fetch->id.'" class="filter_all qualification" value="'.$fetch->id.'"><label for="5'.$fetch->id.'">'.$fetch->qualification.' ('.$cnt.')</label></p>';
					}
				}
				?>
			</div>
		</div>
	</div>
	<div class="widget border">
		<h3 class="sb-title closed">Industry</h3>
		<div class="specialism_widget">
			<div class="simple-checkbox scrollbar">
				<?php
				$retrieve = "SELECT * FROM industries";
				$qery = $conn->prepare($retrieve);
				$qery->execute();
				$results=$qery->fetchAll(PDO::FETCH_OBJ);
				if($qery->rowCount() > 0)
				{
					foreach($results as $fetch)
					{
						$industry_id = $fetch->id;
						$count = "SELECT id FROM jobs WHERE status = 1 AND verified = 1 AND industry_id = :industry_id AND (job_expiry_date > CURDATE())";
						$fetch_id = $conn->prepare($count);
						$fetch_id->bindParam(":industry_id", $industry_id, PDO::PARAM_INT);
						$fetch_id->execute();
						$cnt = $fetch_id->rowCount();
						echo '
						<p><input type="checkbox" id="6'.$fetch->id.'" class="filter_all industry" value="'.$fetch->id.'"><label for="6'.$fetch->id.'">'.$fetch->industry.' ('.$cnt.')</label></p>';
					}
				}
				?>
			</div>
		</div>
	</div>
	<div class="widget border">
		<h3 class="sb-title closed">Job Type</h3>
		<div class="specialism_widget">
			<div class="simple-checkbox scrollbar">
				<?php
				$retrieve = "SELECT * FROM job_types";
				$qery = $conn->prepare($retrieve);
				$qery->execute();
				$results=$qery->fetchAll(PDO::FETCH_OBJ);
				if($qery->rowCount() > 0)
				{
					foreach($results as $fetch)
					{
						$job_type_id = $fetch->id;
						$count = "SELECT id FROM jobs WHERE status = 1 AND verified = 1 AND job_type_id = :job_type_id AND (job_expiry_date > CURDATE())";
						$fetch_id = $conn->prepare($count);
						$fetch_id->bindParam(":job_type_id", $job_type_id, PDO::PARAM_INT);
						$fetch_id->execute();
						$cnt = $fetch_id->rowCount();
						echo '
						<p><input type="checkbox" id="7'.$fetch->id.'" class="filter_all job_type" value="'.$fetch->id.'"><label for="7'.$fetch->id.'">'.$fetch->job_type.' ('.$cnt.')</label></p>';
					}
				}
				?>
			</div>
		</div>
	</div>
	<div class="banner_widget">
		<a href="#" title=""><img src="assets/images/resource/banner.png" alt="" /></a>
	</div>
</aside>