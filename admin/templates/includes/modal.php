<?php ?>
  <div id="exclude-posts-modal" class="wdss-modal">
			<div class="wdss-modal-header">
				<i class="fas fa-times"></i>
			</div>
			<div class="wdss-modal-body">
				<div class="wdss-table-wrapper">
					<table id="wdss-exclude-posts-table" class="wdss-table">
						<tr class="wdss-table-row header">
							<th class="wdss-table-post__select"></th>
							<th class="wdss-table-post__id">ID</th>
							<th class="wdss-table-post__title">Title</th>
							<th class="wdss-table-post__status">Status</th>
							<th class="wdss-table-post__date">Date</th>
						</tr>
					</table>
					<span class="wdss-modal-welcome-msg active">Press "Get Posts" to start</span>
				</div>
			</div>
			<div class="wdss-modal-footer">
				<button type="button" class="wdss-button toggle-all inactive">Toggle All</button>
        <div class="wdss-modal-footer-main">
          <button type="button" class="wdss-button get-posts">Get posts</button>
					<span class="wdss-modal-posts-count"> <strong></strong> post(s) in total</span>
        </div>
				<button type="button" class="wdss-button submit inactive">Execute</button>
			</div>
		</div>