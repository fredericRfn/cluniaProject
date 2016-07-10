<div class="row separator"><span class="table-text"><?php echo ucfirst($_GET["t"])?></span>
<?php if ($addMode): ?>
    <button class="btn btn-default" style="float: right; margin-right: 15px;" type="button"">Delete</button>
    <button class="btn btn-default" style="float: right;" type="button"">Add</button>
<?php endif; ?>
</div>
<div class="container">
    <table class="data table-striped table-bordered table-hover table-sm">
        <thead>
            <tr>
                <?php while ($fields = $resultFields->fetch_assoc()) : ?>
                    <?php if($fields["Field"]!="password") : ?>
                        <th class="fit"><?php echo $fields["Field"] ?></th>
                    <?php endif; ?>
                <?php endwhile; ?>
            </tr>
        </thead>
        <tbody>
            <?php while ($datarow = $result->fetch_assoc()) : ?>
                <?php $rowId = $datarow["id"]; ?>
                <tr>
                    <?php foreach ($datarow as $key => $value) : ?>
                        <?php if($key!="password") : ?>
                            <td class="
                            <?php if(!strpos($key, '_id') and $key!="id" and $key!="password" and $key!="name" and !strpos($key, '_at')) : ?>
                            <?php echo 'clickable_cell' ?>
                            <?php endif; ?>"
                                id="<?php echo $rowId.','.$key ?>" class="fit"><?php echo $value ?></td>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php if ($editMode) : ?>
    <script type="text/javascript" src="../assets/js/inlineform.js"></script>
<?php endif; ?>