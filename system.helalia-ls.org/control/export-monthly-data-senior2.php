<div class="row">
  <div class="col-md-12">
    <button class="btn btn-success btn-block" style="width: 100px; margin-right:10px;  "
      onclick="exportTableToExcel('court-datatables-kids2')">
      تصدير Excel <i class="fa fa-file-excel-o" aria-hidden="true"></i>
    </button>







    <div class="card" id="printable_div_id" style=" width: 100%; font-size: 12px;">



      <div class="card-body" data-toggle="match-height" style="overflow-x:auto;  ">



        <table id="court-datatables-kids2" class="table table-striped table-nowrap dataTable" border="1" cellspacing="0"
          width="100%" style="font-size: 10px !important " dir="ltr">
          <thead>
            <tr>
              <td rowspan="3"
                style="text-align: center; vertical-align: middle; font-size: 16px !important; width: 20px;">م </td>
              <td rowspan="3"
                style="text-align: center; vertical-align: middle; width: 100x; font-size: 16px !important;">الاســـــم
              </td>
              <td rowspan="3"
                style="text-align: center; vertical-align: middle; width: 50x; font-size: 16px !important;">كود </td>
              <td rowspan="3"
                style="text-align: center; vertical-align: middle; width: 50x; font-size: 16px !important;">المادة </td>
              <td colspan="10" style="text-align: center; font-weight: bold; font-size: 16px !important;"> متوسط </td>
            </tr>
            </tr>
            <tr>
              <?php
              $query_get_title = "SELECT * FROM `control_registry_avg_title` WHERE `study_year`= '{$_GET['year']}'    ";
              $get_title = mysqli_query($database, $query_get_title) or die(mysqli_error($database));
              $row_get_title = mysqli_fetch_assoc($get_title);
              $totalRows_get_title = mysqli_num_rows($get_title);

              $query_get_exam1 = "SELECT * FROM `control` WHERE `study_year`= '{$_GET['year']}' AND `month` = '{$month1}' $class ";
              $get_exam1 = mysqli_query($database, $query_get_exam1) or die(mysqli_error($database));
              $row_get_exam1 = mysqli_fetch_assoc($get_exam1);
              $totalRows_get_exam1 = mysqli_num_rows($get_exam1);

              $query_get_exam2 = "SELECT * FROM `control` WHERE `study_year`= '{$_GET['year']}'    AND `month` = '{$month2}' $class ";
              $get_exam2 = mysqli_query($database, $query_get_exam2) or die(mysqli_error($database));
              $row_get_exam2 = mysqli_fetch_assoc($get_exam2);
              $totalRows_get_exam2 = mysqli_num_rows($get_exam2);

              ?>
              <?php if ($row_get_title['col1_total'] > 0) { ?>
                <th class="text-center" style="width: 25px; white-space: pre-wrap; word-wrap: break-word;">
                  <?php echo $row_get_title['col1']; ?>
                </th><?php } ?>
              <?php if ($row_get_title['col2_total'] > 0) { ?>
                <th class="text-center" style="width: 25px; white-space: pre-wrap; word-wrap: break-word;">
                  <?php echo $row_get_title['col2']; ?>
                </th><?php } ?>
              <?php if ($row_get_title['col3_total'] > 0) { ?>
                <th class="text-center" style="width: 25px; white-space: pre-wrap; word-wrap: break-word;">
                  <?php echo $row_get_title['col3']; ?>
                </th><?php } ?>
              <?php if ($row_get_title['col4_total'] > 0) { ?>
                <th class="text-center" style="width: 25px; white-space: pre-wrap; word-wrap: break-word;">
                  <?php echo $row_get_title['col4']; ?>
                </th><?php } ?>
              <?php if ($row_get_title['col5_total'] > 0) { ?>
                <th class="text-center" style="width: 25px; white-space: pre-wrap; word-wrap: break-word;">
                  <?php echo $row_get_title['col5']; ?>
                </th><?php } ?>
              <?php if ($row_get_title['col6_total'] > 0) { ?>
                <th class="text-center" style="width: 25px; white-space: pre-wrap; word-wrap: break-word;">
                  <?php echo $row_get_title['col6']; ?>
                </th><?php } ?>
              <?php if ($row_get_title['col7_total'] > 0) { ?>
                <th class="text-center" style="width: 25px; white-space: pre-wrap; word-wrap: break-word;">
                  <?php echo $row_get_title['col7']; ?>
                </th><?php } ?>
              <?php if ($row_get_title['col8_total'] > 0) { ?>
                <th class="text-center" style="width: 25px; white-space: pre-wrap; word-wrap: break-word;">
                  <?php echo $row_get_title['col8']; ?>
                </th><?php } ?>
              <?php if ($row_get_title['col9_total'] > 0) { ?>
                <th class="text-center" style="width: 25px; white-space: pre-wrap; word-wrap: break-word;">
                  <?php echo $row_get_title['col9']; ?>
                </th><?php } ?>
              <?php if ($row_get_title['col10_total'] > 0) { ?>
                <th class="text-center" style="width: 25px; white-space: pre-wrap; word-wrap: break-word;">
                  <?php echo $row_get_title['col10']; ?>
                </th><?php } ?>
              <?php if ($row_get_title['col11_total'] > 0) { ?>
                <th class="text-center" style="width: 25px; white-space: pre-wrap; word-wrap: break-word;">
                  <?php echo $row_get_title['col11']; ?>
                </th><?php } ?>
              <?php if ($row_get_title['col12_total'] > 0) { ?>
                <th class="text-center" style="width: 25px; white-space: pre-wrap; word-wrap: break-word;">
                  <?php echo $row_get_title['col12']; ?>
                </th><?php } ?>
              <?php if ($row_get_title['col13_total'] > 0) { ?>
                <th class="text-center" style="width: 25px; white-space: pre-wrap; word-wrap: break-word;">
                  <?php echo $row_get_title['col13']; ?>
                </th><?php } ?>
              <?php if ($row_get_title['col14_total'] > 0) { ?>
                <th class="text-center" style="width: 25px; white-space: pre-wrap; word-wrap: break-word;">
                  <?php echo $row_get_title['col14']; ?>
                </th><?php } ?>
              <?php if ($row_get_title['col15_total'] > 0) { ?>
                <th class="text-center" style="width: 25px; white-space: pre-wrap; word-wrap: break-word;">
                  <?php echo $row_get_title['col15']; ?>
                </th><?php } ?>
              <th class="text-center" style="width: 25px;"> المجموع </th>

              <?php if ($_GET['year'] >= 5) { ?>
                <th class="text-center" style="width: 120px; font-size: 14px !important;"> شهر 1 </th>
                <th class="text-center" style="width: 120px; font-size: 14px !important;"> شهر 2 </th>
                <th class="text-center" style="width: 120px; font-size: 14px !important;"> المجموع </th>
              <?php } ?>
            </tr>
            <tr>
              <?php if ($row_get_title['col1_total'] > 0) { ?>
                <th class="text-center"><?php echo $row_get_title['col1_total']; ?></th><?php } ?>
              <?php if ($row_get_title['col2_total'] > 0) { ?>
                <th class="text-center"><?php echo $row_get_title['col2_total']; ?></th><?php } ?>
              <?php if ($row_get_title['col3_total'] > 0) { ?>
                <th class="text-center"><?php echo $row_get_title['col3_total']; ?></th><?php } ?>
              <?php if ($row_get_title['col4_total'] > 0) { ?>
                <th class="text-center"><?php echo $row_get_title['col4_total']; ?></th><?php } ?>
              <?php if ($row_get_title['col5_total'] > 0) { ?>
                <th class="text-center"><?php echo $row_get_title['col5_total']; ?></th><?php } ?>
              <?php if ($row_get_title['col6_total'] > 0) { ?>
                <th class="text-center"><?php echo $row_get_title['col6_total']; ?></th><?php } ?>
              <?php if ($row_get_title['col7_total'] > 0) { ?>
                <th class="text-center"><?php echo $row_get_title['col7_total']; ?></th><?php } ?>
              <?php if ($row_get_title['col8_total'] > 0) { ?>
                <th class="text-center"><?php echo $row_get_title['col8_total']; ?></th><?php } ?>
              <?php if ($row_get_title['col9_total'] > 0) { ?>
                <th class="text-center"><?php echo $row_get_title['col9_total']; ?></th><?php } ?>
              <?php if ($row_get_title['col10_total'] > 0) { ?>
                <th class="text-center"><?php echo $row_get_title['col10_total']; ?></th><?php } ?>
              <?php if ($row_get_title['col11_total'] > 0) { ?>
                <th class="text-center"><?php echo $row_get_title['col11_total']; ?></th><?php } ?>
              <?php if ($row_get_title['col12_total'] > 0) { ?>
                <th class="text-center"><?php echo $row_get_title['col12_total']; ?></th><?php } ?>
              <?php if ($row_get_title['col13_total'] > 0) { ?>
                <th class="text-center"><?php echo $row_get_title['col13_total']; ?></th><?php } ?>
              <?php if ($row_get_title['col14_total'] > 0) { ?>
                <th class="text-center"><?php echo $row_get_title['col14_total']; ?></th><?php } ?>
              <?php if ($row_get_title['col15_total'] > 0) { ?>
                <th class="text-center"><?php echo $row_get_title['col15_total']; ?></th><?php } ?>
              <th class="text-center" style="width: 120px; font-size: 14px !important;">
                <?php echo ($row_get_title['col1_total'] + $row_get_title['col2_total'] + $row_get_title['col3_total'] + $row_get_title['col4_total'] + $row_get_title['col5_total'] + $row_get_title['col6_total'] + $row_get_title['col7_total'] + $row_get_title['col8_total'] + $row_get_title['col9_total'] + $row_get_title['col10_total'] + $row_get_title['col11_total'] + $row_get_title['col12_total'] + $row_get_title['col13_total'] + $row_get_title['col14_total'] + $row_get_title['col15_total']); ?>
              </th>

              <?php if ($_GET['year'] >= 5) { ?>
                <th class="text-center"><?php echo $row_get_exam1['ex_total']; ?></th>
                <th class="text-center"><?php echo $row_get_exam2['ex_total']; ?></th>
                <th class="text-center">
                  <?php echo ($row_get_exam1['ex_total'] + $row_get_exam2['ex_total'] + $row_get_title['col1_total'] + $row_get_title['col2_total'] + $row_get_title['col3_total'] + $row_get_title['col4_total'] + $row_get_title['col5_total'] + $row_get_title['col6_total'] + $row_get_title['col7_total'] + $row_get_title['col8_total'] + $row_get_title['col9_total'] + $row_get_title['col10_total'] + $row_get_title['col11_total'] + $row_get_title['col12_total'] + $row_get_title['col13_total'] + $row_get_title['col14_total'] + $row_get_title['col15_total']); ?>
                </th>
              <?php } ?>
            </tr>
          </thead>
          <tbody>
            <?php

            $query_get_registry = "SELECT * FROM `control_registry_avg` WHERE `study_year`= '{$_GET['year']}' AND `month`= '{$month}'  order by  `subject_id` asc, `kid_id` asc ";
            $get_registry = mysqli_query($database, $query_get_registry) or die(mysqli_error($database));
            $row_get_registry = mysqli_fetch_assoc($get_registry);
            $totalRows_get_registry = mysqli_num_rows($get_registry);

            if ($totalRows_get_registry > 0) {
              do {


                $query_get_data = "SELECT * FROM `kids` WHERE  `id` = '{$row_get_registry['kid_id']}' $class ";
                $get_data = mysqli_query($database, $query_get_data) or die(mysqli_error($database));
                $row_get_data = mysqli_fetch_assoc($get_data);
                $totalRows_get_data = mysqli_num_rows($get_data);

                if ($totalRows_get_data > 0) {


                  $query_get_exam1 = "SELECT * FROM `control` WHERE `study_year`= '{$_GET['year']}' AND `kid_id` = '{$row_get_registry['kid_id']}' AND `month` = '{$month1}'  and `subject_id`= '{$row_get_registry['subject_id']}'  ";
                  $get_exam1 = mysqli_query($database, $query_get_exam1) or die(mysqli_error($database));
                  $row_get_exam1 = mysqli_fetch_assoc($get_exam1);
                  $totalRows_get_exam1 = mysqli_num_rows($get_exam1);

                  $query_get_exam2 = "SELECT * FROM `control` WHERE `study_year`= '{$_GET['year']}' AND `kid_id` = '{$row_get_registry['kid_id']}'AND `month` = '{$month2}'  and `subject_id`= '{$row_get_registry['subject_id']}' ";
                  $get_exam2 = mysqli_query($database, $query_get_exam2) or die(mysqli_error($database));
                  $row_get_exam2 = mysqli_fetch_assoc($get_exam2);
                  $totalRows_get_exam2 = mysqli_num_rows($get_exam2);
                  ?>

                  <tr>
                    <td class="text-center" style=" border:solid 1px black; vertical-align: middle; ">
                      <?php echo subject_name($row_get_registry['subject_id']); ?>
                    </td>
                    <td class="text-<?php if (isset($_GET['lang']) && $_GET['lang'] == 2) {
                      echo 'left';
                    } else {
                      echo 'right';
                    } ?>"
                      style="text-align:<?php if (isset($_GET['lang']) && $_GET['lang'] == 2) {
                        echo 'left';
                      } else {
                        echo 'right';
                      } ?>; border:solid 1px black; width:130px; font-size: 14px !important; padding-top: 1px !important; padding-bottom: 1px !important;color: black; padding-left: 3px !important;  padding-right:5px !important;">
                      <?php if (isset($_GET['lang']) && $_GET['lang'] == 2) {
                        echo $row_get_data['fn_name'];
                      } else {
                        echo $row_get_data['name'];
                      } ?>
                    </td>
                    <td class="text-center"
                      style="text-align:center; border:solid 1px black;  width:50px; font-size: 14px !important; padding-top: 1px !important; padding-bottom: 1px !important;color: black; padding-left: 3px !important;  padding-right:5px !important;">
                      <?php echo $row_get_data['ed_id']; ?>
                    </td>
                    <td class="text-center"
                      style="text-align:center; border:solid 1px black;  width:30px; font-size: 14px !important; padding-top: 1px !important; padding-bottom: 1px !important;color: black; padding-left: 3px !important;  padding-right:5px !important;">
                      <?php echo $row_get_registry['subject_id']; ?>
                    </td>

                    <?php if ($row_get_title['col1_total'] > 0) { ?>
                      <td class="text-center" style=" border:solid 1px black; text-align: center; vertical-align: middle;">
                        <?php echo $row_get_registry['col1']; ?>
                      </td><?php } ?>
                    <?php if ($row_get_title['col2_total'] > 0) { ?>
                      <td class="text-center" style=" border:solid 1px black; text-align: center; vertical-align: middle;">
                        <?php echo $row_get_registry['col2']; ?>
                      </td><?php } ?>
                    <?php if ($row_get_title['col3_total'] > 0) { ?>
                      <td class="text-center" style=" border:solid 1px black; text-align: center; vertical-align: middle;">
                        <?php echo $row_get_registry['col3']; ?>
                      </td><?php } ?>
                    <?php if ($row_get_title['col4_total'] > 0) { ?>
                      <td class="text-center" style=" border:solid 1px black; text-align: center; vertical-align: middle;">
                        <?php echo $row_get_registry['col4']; ?>
                      </td><?php } ?>
                    <?php if ($row_get_title['col5_total'] > 0) { ?>
                      <td class="text-center" style=" border:solid 1px black; text-align: center; vertical-align: middle;">
                        <?php echo $row_get_registry['col5']; ?>
                      </td><?php } ?>
                    <?php if ($row_get_title['col6_total'] > 0) { ?>
                      <td class="text-center" style=" border:solid 1px black; text-align: center; vertical-align: middle;">
                        <?php echo $row_get_registry['col6']; ?>
                      </td><?php } ?>
                    <?php if ($row_get_title['col7_total'] > 0) { ?>
                      <td class="text-center" style=" border:solid 1px black; text-align: center; vertical-align: middle;">
                        <?php echo $row_get_registry['col7']; ?>
                      </td><?php } ?>
                    <?php if ($row_get_title['col8_total'] > 0) { ?>
                      <td class="text-center" style=" border:solid 1px black; text-align: center; vertical-align: middle;">
                        <?php echo $row_get_registry['col8']; ?>
                      </td><?php } ?>
                    <?php if ($row_get_title['col9_total'] > 0) { ?>
                      <td class="text-center" style=" border:solid 1px black; text-align: center; vertical-align: middle;">
                        <?php echo $row_get_registry['col9']; ?>
                      </td><?php } ?>
                    <?php if ($row_get_title['col10_total'] > 0) { ?>
                      <td class="text-center" style=" border:solid 1px black; text-align: center; vertical-align: middle;">
                        <?php echo $row_get_registry['col10']; ?>
                      </td><?php } ?>
                    <?php if ($row_get_title['col11_total'] > 0) { ?>
                      <td class="text-center" style=" border:solid 1px black; text-align: center; vertical-align: middle;">
                        <?php echo $row_get_registry['col11']; ?>
                      </td><?php } ?>
                    <?php if ($row_get_title['col12_total'] > 0) { ?>
                      <td class="text-center" style=" border:solid 1px black; text-align: center; vertical-align: middle;">
                        <?php echo $row_get_registry['col12']; ?>
                      </td><?php } ?>
                    <?php if ($row_get_title['col13_total'] > 0) { ?>
                      <td class="text-center" style=" border:solid 1px black; text-align: center; vertical-align: middle;">
                        <?php echo $row_get_registry['col13']; ?>
                      </td><?php } ?>
                    <?php if ($row_get_title['col14_total'] > 0) { ?>
                      <td class="text-center" style=" border:solid 1px black; text-align: center; vertical-align: middle;">
                        <?php echo $row_get_registry['col14']; ?>
                      </td><?php } ?>
                    <?php if ($row_get_title['col15_total'] > 0) { ?>
                      <td class="text-center" style=" border:solid 1px black; text-align: center; vertical-align: middle;">
                        <?php echo $row_get_registry['col15']; ?>
                      </td><?php } ?>
                    <td class="text-center" style=" border:solid 1px black; text-align: center; vertical-align: middle;">
                      <?php if (($row_get_registry['col1'] + $row_get_registry['col2'] + $row_get_registry['col3'] + $row_get_registry['col4'] + $row_get_registry['col5'] + $row_get_registry['col6'] + $row_get_registry['col7'] + $row_get_registry['col8'] + $row_get_registry['col9'] + $row_get_registry['col10'] + $row_get_registry['col11'] + $row_get_registry['col12'] + $row_get_registry['col13'] + $row_get_registry['col14'] + $row_get_registry['col15']) > 0) {
                        echo ($row_get_registry['col1'] + $row_get_registry['col2'] + $row_get_registry['col3'] + $row_get_registry['col4'] + $row_get_registry['col5'] + $row_get_registry['col6'] + $row_get_registry['col7'] + $row_get_registry['col8'] + $row_get_registry['col9'] + $row_get_registry['col10'] + $row_get_registry['col11'] + $row_get_registry['col12'] + $row_get_registry['col13'] + $row_get_registry['col14'] + $row_get_registry['col15']);
                      } ?>
                    </td>
                    <?php if ($_GET['year'] >= 5) { ?>
                      <td class="text-center" style=" border:solid 1px black; text-align: center; vertical-align: middle;">
                        <?php echo $row_get_exam1['ex_result']; ?>
                      </td>
                      <td class="text-center" style=" border:solid 1px black; text-align: center; vertical-align: middle;">
                        <?php echo $row_get_exam2['ex_result']; ?>
                      </td>
                      <td class="text-center" style=" border:solid 1px black; text-align: center; vertical-align: middle;">
                        <?php if (($row_get_exam1['ex_result'] + $row_get_exam2['ex_result'] + $row_get_registry['col1'] + $row_get_registry['col2'] + $row_get_registry['col3'] + $row_get_registry['col4'] + $row_get_registry['col5'] + $row_get_registry['col6'] + $row_get_registry['col7'] + $row_get_registry['col8'] + $row_get_registry['col9'] + $row_get_registry['col10'] + $row_get_registry['col11'] + $row_get_registry['col12'] + $row_get_registry['col13'] + $row_get_registry['col14'] + $row_get_registry['col15']) > 0) {
                          echo ($row_get_exam1['ex_result'] + $row_get_exam2['ex_result'] + $row_get_registry['col1'] + $row_get_registry['col2'] + $row_get_registry['col3'] + $row_get_registry['col4'] + $row_get_registry['col5'] + $row_get_registry['col6'] + $row_get_registry['col7'] + $row_get_registry['col8'] + $row_get_registry['col9'] + $row_get_registry['col10'] + $row_get_registry['col11'] + $row_get_registry['col12'] + $row_get_registry['col13'] + $row_get_registry['col14'] + $row_get_registry['col15']);
                        } ?>
                      </td>
                    <?php } ?>
                  </tr>

                <?php }
              } while ($row_get_registry = mysqli_fetch_assoc($get_registry));
            } ?>

          </tbody>
        </table>



      </div>



    </div>
  </div>
</div>