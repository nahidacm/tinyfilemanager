<?php

//--- FILEMANAGER MAIN
fm_show_header(); // HEADER
fm_show_nav_path(FM_PATH); // current path

// messages
fm_show_message();

$num_files = count($files);
$num_folders = count($folders);
$all_files_size = 0;
?>
    <form action="" method="post" class="pt-3">
        <input type="hidden" name="p" value="<?php echo fm_enc(FM_PATH) ?>">
        <input type="hidden" name="group" value="1">
        <div class="row">
                <?php
                // link to parent folder
                if ($parent !== false) {
                    ?>
                    <div class="col-12">
                        <a href="?p=<?php echo urlencode($parent) ?>"><i class="fa fa-chevron-circle-left go-back"></i> ..</a>
                    </div>
                    <?php
                }
                $ii = 3399;
                foreach ($folders as $f) {
                    $is_link = is_link($path . '/' . $f);
                    $img = $is_link ? 'icon-link_folder' : 'fa fa-folder-open';
                    $modif = date(FM_DATETIME_FORMAT, filemtime($path . '/' . $f));
                    $perms = substr(decoct(fileperms($path . '/' . $f)), -4);
                    if (function_exists('posix_getpwuid') && function_exists('posix_getgrgid')) {
                        $owner = posix_getpwuid(fileowner($path . '/' . $f));
                        $group = posix_getgrgid(filegroup($path . '/' . $f));
                    } else {
                        $owner = array('name' => '?');
                        $group = array('name' => '?');
                    }
                    ?>
                    <div class="col-2">
                        <div class="card">
                            <?php if (!FM_READONLY): ?>
                                <div class="custom-checkbox-td">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="<?php echo $ii ?>" name="file[]" value="<?php echo fm_enc($f) ?>">
                                    <label class="custom-control-label" for="<?php echo $ii ?>"></label>
                                </div>
                                </div>
                            <?php endif; ?>
                            <a class="card-img-top" href="?p=<?php echo urlencode(trim(FM_PATH . '/' . $f, '/')) ?>">
                                <i class="<?php echo $img ?>"></i>
                                <h5 class="card-title"><?php echo fm_convert_win($f) ?></h5>
                            </a>
                            <div class="card-body">
                                <div class="filename">
                                    <?php echo($is_link ? ' &rarr; <i>' . readlink($path . '/' . $f) . '</i>' : '') ?>
                                </div>
                                <div class="inline-actions"><?php if (!FM_READONLY): ?>
                                        <a title="<?php echo lng('Delete')?>" href="?p=<?php echo urlencode(FM_PATH) ?>&amp;del=<?php echo urlencode($f) ?>" onclick="return confirm('Delete folder?');"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                        <a title="<?php echo lng('Rename')?>" href="#" onclick="rename('<?php echo fm_enc(FM_PATH) ?>', '<?php echo fm_enc(addslashes($f)) ?>');return false;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                        <a title="<?php echo lng('CopyTo')?>..." href="?p=&amp;copy=<?php echo urlencode(trim(FM_PATH . '/' . $f, '/')) ?>"><i class="fa fa-files-o" aria-hidden="true"></i></a>
                                    <?php endif; ?>
                                    <a title="<?php echo lng('DirectLink')?>" href="<?php echo fm_enc(FM_ROOT_URL . (FM_PATH != '' ? '/' . FM_PATH : '') . '/' . $f . '/') ?>" target="_blank"><i class="fa fa-link" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    flush();
                    $ii++;
                }
                $ik = 6070;
                foreach ($files as $f) {
                    $is_link = is_link($path . '/' . $f);
                    $img = $is_link ? 'fa fa-file-text-o' : fm_get_file_icon_class($path . '/' . $f);
                    $modif = date(FM_DATETIME_FORMAT, filemtime($path . '/' . $f));
                    $filesize_raw = fm_get_size($path . '/' . $f);
                    $filesize = fm_get_filesize($filesize_raw);
                    $filelink = '?p=' . urlencode(FM_PATH) . '&amp;view=' . urlencode($f);
                    $all_files_size += $filesize_raw;
                    $perms = substr(decoct(fileperms($path . '/' . $f)), -4);
                    if (function_exists('posix_getpwuid') && function_exists('posix_getgrgid')) {
                        $owner = posix_getpwuid(fileowner($path . '/' . $f));
                        $group = posix_getgrgid(filegroup($path . '/' . $f));
                    } else {
                        $owner = array('name' => '?');
                        $group = array('name' => '?');
                    }
                    ?>
                    <div class="col-2">
                        <div class="card">
                            <?php if (!FM_READONLY): ?>
                                <div class="custom-checkbox-td">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="<?php echo $ik ?>" name="file[]" value="<?php echo fm_enc($f) ?>">
                                    <label class="custom-control-label" for="<?php echo $ik ?>"></label>
                                </div>
                                </div><?php endif; ?>
                            <a class="card-img-top" href="<?php echo $filelink ?>" title="File info">
                                <i class="<?php echo $img ?>"></i>
                                <h5 class="card-title"><?php echo fm_convert_win($f) ?></h5>
                            </a>
                            <div class="card-body">
                                <div class="filename">
                                    <?php echo($is_link ? ' &rarr; <i>' . readlink($path . '/' . $f) . '</i>' : '') ?>
                                </div>

                                <div class="inline-actions">
                                    <?php if (!FM_READONLY): ?>
                                        <a title="<?php echo lng('Preview') ?>" href="<?php echo $filelink.'&quickView=1'; ?>" data-toggle="lightbox" data-gallery="tiny-gallery" data-title="<?php echo fm_convert_win($f) ?>" data-max-width="100%" data-width="100%"><i class="fa fa-eye"></i></a>
                                        <a title="<?php echo lng('Delete') ?>" href="?p=<?php echo urlencode(FM_PATH) ?>&amp;del=<?php echo urlencode($f) ?>" onclick="return confirm('Delete file?');"><i class="fa fa-trash-o"></i></a>
                                        <a title="<?php echo lng('Rename') ?>" href="#" onclick="rename('<?php echo fm_enc(FM_PATH) ?>', '<?php echo fm_enc(addslashes($f)) ?>');return false;"><i class="fa fa-pencil-square-o"></i></a>
                                        <a title="<?php echo lng('CopyTo') ?>..."
                                           href="?p=<?php echo urlencode(FM_PATH) ?>&amp;copy=<?php echo urlencode(trim(FM_PATH . '/' . $f, '/')) ?>"><i class="fa fa-files-o"></i></a>
                                    <?php endif; ?>
                                    <a title="<?php echo lng('DirectLink') ?>" href="<?php echo fm_enc(FM_ROOT_URL . (FM_PATH != '' ? '/' . FM_PATH : '') . '/' . $f) ?>" target="_blank"><i class="fa fa-link"></i></a>
                                    <a title="<?php echo lng('Download') ?>" href="?p=<?php echo urlencode(FM_PATH) ?>&amp;dl=<?php echo urlencode($f) ?>"><i class="fa fa-download"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    flush();
                    $ik++;
                }

                if (empty($folders) && empty($files)) {
                    ?>
                    <tfoot>
                    <tr><?php if (!FM_READONLY): ?>
                            <td></td><?php endif; ?>
                        <td colspan="<?php echo !FM_IS_WIN ? '6' : '4' ?>"><em><?php echo 'Folder is empty' ?></em></td>
                    </tr>
                    </tfoot>
                    <?php
                } else {
                    ?>
                    <div class="col-12">
                    <div><?php if (!FM_READONLY): ?>
                            <div class="gray"></div><?php endif; ?>
                        <div class="gray" colspan="<?php echo !FM_IS_WIN ? '6' : '4' ?>">
                            Full size: <span title="<?php printf('%s bytes', $all_files_size) ?>"><?php echo '<span class="badge badge-light">'.fm_get_filesize($all_files_size).'</span>' ?></span>
                            <?php echo lng('File').': <span class="badge badge-light">'.$num_files.'</span>' ?>
                            <?php echo lng('Folder').': <span class="badge badge-light">'.$num_folders.'</span>' ?>
                            <?php echo lng('MemoryUsed').': <span class="badge badge-light">'.fm_get_filesize(@memory_get_usage(true)).'</span>' ?>
                            <?php echo lng('PartitionSize').': <span class="badge badge-light">'.fm_get_filesize(@disk_free_space($path)) .'</span> free of <span class="badge badge-light">'.fm_get_filesize(@disk_total_space($path)).'</span>'; ?>
                        </div>
                    </div>
                    </div>
                    <?php
                }
                ?>
        </div>

        <div class="row">
            <?php if (!FM_READONLY): ?>
                <div class="col-xs-12 col-sm-9">
                    <ul class="list-inline footer-action">
                        <li class="list-inline-item"> <a href="#/select-all" class="btn btn-small btn-outline-primary btn-2" onclick="select_all();return false;"><i class="fa fa-check-square"></i> <?php echo lng('SelectAll') ?> </a></li>
                        <li class="list-inline-item"><a href="#/unselect-all" class="btn btn-small btn-outline-primary btn-2" onclick="unselect_all();return false;"><i class="fa fa-window-close"></i> <?php echo lng('UnSelectAll') ?> </a></li>
                        <li class="list-inline-item"><a href="#/invert-all" class="btn btn-small btn-outline-primary btn-2" onclick="invert_all();return false;"><i class="fa fa-th-list"></i> <?php echo lng('InvertSelection') ?> </a></li>
                        <li class="list-inline-item"><input type="submit" class="hidden" name="delete" id="a-delete" value="Delete" onclick="return confirm('Delete selected files and folders?')">
                            <a href="javascript:document.getElementById('a-delete').click();" class="btn btn-small btn-outline-primary btn-2"><i class="fa fa-trash"></i> <?php echo lng('Delete') ?> </a></li>
                        <li class="list-inline-item"><input type="submit" class="hidden" name="zip" id="a-zip" value="zip" onclick="return confirm('Create archive?')">
                            <a href="javascript:document.getElementById('a-zip').click();" class="btn btn-small btn-outline-primary btn-2"><i class="fa fa-file-archive-o"></i> <?php echo lng('Zip') ?> </a></li>
                        <li class="list-inline-item"><input type="submit" class="hidden" name="tar" id="a-tar" value="tar" onclick="return confirm('Create archive?')">
                            <a href="javascript:document.getElementById('a-tar').click();" class="btn btn-small btn-outline-primary btn-2"><i class="fa fa-file-archive-o"></i> <?php echo lng('Tar') ?> </a></li>
                        <li class="list-inline-item"><input type="submit" class="hidden" name="copy" id="a-copy" value="Copy">
                            <a href="javascript:document.getElementById('a-copy').click();" class="btn btn-small btn-outline-primary btn-2"><i class="fa fa-files-o"></i> <?php echo lng('Copy') ?> </a></li>
                    </ul>
                </div>
                <div class="col-3 d-none d-sm-block"><a href="#" target="_blank" class="float-right text-muted">KrishiTV File Manager <?php echo VERSION; ?></a></div>
            <?php else: ?>
                <div class="col-12"><a href="#" target="_blank" class="float-right text-muted">KrishiTV File Manager <?php echo VERSION; ?></a></div>
            <?php endif; ?>
        </div>

    </form>

<?php
fm_show_footer();

//--- END
