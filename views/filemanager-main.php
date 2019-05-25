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
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-sm bg-white" id="main-table">
                <thead class="thead-white">
                <tr>
                    <?php if (!FM_READONLY): ?>
                        <th style="width:3%" class="custom-checkbox-header">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="js-select-all-items" onclick="checkbox_toggle()">
                                <label class="custom-control-label" for="js-select-all-items"></label>
                            </div>
                        </th><?php endif; ?>
                    <th><?php echo lng('Name') ?></th>
                    <th><?php echo lng('Size') ?></th>
                    <th><?php echo lng('Modified') ?></th>
                    <?php if (!FM_IS_WIN): ?>
                        <th><?php echo lng('Perms') ?></th>
                        <th><?php echo lng('Owner') ?></th><?php endif; ?>
                    <th><?php echo lng('Actions') ?></th>
                </tr>
                </thead>
                <?php
                // link to parent folder
                if ($parent !== false) {
                    ?>
                    <tr><?php if (!FM_READONLY): ?>
                            <td class="nosort"></td><?php endif; ?>
                        <td class="border-0"><a href="?p=<?php echo urlencode($parent) ?>"><i class="fa fa-chevron-circle-left go-back"></i> ..</a></td>
                        <td class="border-0"></td>
                        <td class="border-0"></td>
                        <td class="border-0"></td>
                        <?php if (!FM_IS_WIN) { ?>
                            <td class="border-0"></td>
                            <td class="border-0"></td>
                        <?php } ?>
                    </tr>
                    <?php
                }
                $ii = 3399;
                foreach ($folders as $f) {
                    $is_link = is_link($path . '/' . $f);
                    $img = $is_link ? 'icon-link_folder' : 'fa fa-folder-o';
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
                    <tr>
                        <?php if (!FM_READONLY): ?>
                            <td class="custom-checkbox-td">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="<?php echo $ii ?>" name="file[]" value="<?php echo fm_enc($f) ?>">
                                <label class="custom-control-label" for="<?php echo $ii ?>"></label>
                            </div>
                            </td><?php endif; ?>
                        <td>
                            <div class="filename"><a href="?p=<?php echo urlencode(trim(FM_PATH . '/' . $f, '/')) ?>"><i class="<?php echo $img ?>"></i> <?php echo fm_convert_win($f) ?>
                                </a><?php echo($is_link ? ' &rarr; <i>' . readlink($path . '/' . $f) . '</i>' : '') ?></div>
                        </td>
                        <td><?php echo lng('Folder') ?></td>
                        <td><?php echo $modif ?></td>
                        <?php if (!FM_IS_WIN): ?>
                            <td><?php if (!FM_READONLY): ?><a title="Change Permissions" href="?p=<?php echo urlencode(FM_PATH) ?>&amp;chmod=<?php echo urlencode($f) ?>"><?php echo $perms ?></a><?php else: ?><?php echo $perms ?><?php endif; ?>
                            </td>
                            <td><?php echo $owner['name'] . ':' . $group['name'] ?></td>
                        <?php endif; ?>
                        <td class="inline-actions"><?php if (!FM_READONLY): ?>
                                <a title="<?php echo lng('Delete')?>" href="?p=<?php echo urlencode(FM_PATH) ?>&amp;del=<?php echo urlencode($f) ?>" onclick="return confirm('Delete folder?');"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                <a title="<?php echo lng('Rename')?>" href="#" onclick="rename('<?php echo fm_enc(FM_PATH) ?>', '<?php echo fm_enc(addslashes($f)) ?>');return false;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                <a title="<?php echo lng('CopyTo')?>..." href="?p=&amp;copy=<?php echo urlencode(trim(FM_PATH . '/' . $f, '/')) ?>"><i class="fa fa-files-o" aria-hidden="true"></i></a>
                            <?php endif; ?>
                            <a title="<?php echo lng('DirectLink')?>" href="<?php echo fm_enc(FM_ROOT_URL . (FM_PATH != '' ? '/' . FM_PATH : '') . '/' . $f . '/') ?>" target="_blank"><i class="fa fa-link" aria-hidden="true"></i></a>
                        </td>
                    </tr>
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
                    <tr>
                        <?php if (!FM_READONLY): ?>
                            <td class="custom-checkbox-td">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="<?php echo $ik ?>" name="file[]" value="<?php echo fm_enc($f) ?>">
                                <label class="custom-control-label" for="<?php echo $ik ?>"></label>
                            </div>
                            </td><?php endif; ?>
                        <td>
                            <div class="filename"><a href="<?php echo $filelink ?>" title="File info"><i class="<?php echo $img ?>"></i> <?php echo fm_convert_win($f) ?>
                                </a><?php echo($is_link ? ' &rarr; <i>' . readlink($path . '/' . $f) . '</i>' : '') ?></div>
                        </td>
                        <td><span title="<?php printf('%s bytes', $filesize_raw) ?>"><?php echo $filesize ?></span></td>
                        <td><?php echo $modif ?></td>
                        <?php if (!FM_IS_WIN): ?>
                            <td><?php if (!FM_READONLY): ?><a title="<?php echo 'Change Permissions' ?>" href="?p=<?php echo urlencode(FM_PATH) ?>&amp;chmod=<?php echo urlencode($f) ?>"><?php echo $perms ?></a><?php else: ?><?php echo $perms ?><?php endif; ?>
                            </td>
                            <td><?php echo fm_enc($owner['name'] . ':' . $group['name']) ?></td>
                        <?php endif; ?>
                        <td class="inline-actions">
                            <?php if (!FM_READONLY): ?>
                                <a title="<?php echo lng('Preview') ?>" href="<?php echo $filelink.'&quickView=1'; ?>" data-toggle="lightbox" data-gallery="tiny-gallery" data-title="<?php echo fm_convert_win($f) ?>" data-max-width="100%" data-width="100%"><i class="fa fa-eye"></i></a>
                                <a title="<?php echo lng('Delete') ?>" href="?p=<?php echo urlencode(FM_PATH) ?>&amp;del=<?php echo urlencode($f) ?>" onclick="return confirm('Delete file?');"><i class="fa fa-trash-o"></i></a>
                                <a title="<?php echo lng('Rename') ?>" href="#" onclick="rename('<?php echo fm_enc(FM_PATH) ?>', '<?php echo fm_enc(addslashes($f)) ?>');return false;"><i class="fa fa-pencil-square-o"></i></a>
                                <a title="<?php echo lng('CopyTo') ?>..."
                                   href="?p=<?php echo urlencode(FM_PATH) ?>&amp;copy=<?php echo urlencode(trim(FM_PATH . '/' . $f, '/')) ?>"><i class="fa fa-files-o"></i></a>
                            <?php endif; ?>
                            <a title="<?php echo lng('DirectLink') ?>" href="<?php echo fm_enc(FM_ROOT_URL . (FM_PATH != '' ? '/' . FM_PATH : '') . '/' . $f) ?>" target="_blank"><i class="fa fa-link"></i></a>
                            <a title="<?php echo lng('Download') ?>" href="?p=<?php echo urlencode(FM_PATH) ?>&amp;dl=<?php echo urlencode($f) ?>"><i class="fa fa-download"></i></a>
                        </td>
                    </tr>
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
                    <tfoot>
                    <tr><?php if (!FM_READONLY): ?>
                            <td class="gray"></td><?php endif; ?>
                        <td class="gray" colspan="<?php echo !FM_IS_WIN ? '6' : '4' ?>">
                            Full size: <span title="<?php printf('%s bytes', $all_files_size) ?>"><?php echo '<span class="badge badge-light">'.fm_get_filesize($all_files_size).'</span>' ?></span>
                            <?php echo lng('File').': <span class="badge badge-light">'.$num_files.'</span>' ?>
                            <?php echo lng('Folder').': <span class="badge badge-light">'.$num_folders.'</span>' ?>
                            <?php echo lng('MemoryUsed').': <span class="badge badge-light">'.fm_get_filesize(@memory_get_usage(true)).'</span>' ?>
                            <?php echo lng('PartitionSize').': <span class="badge badge-light">'.fm_get_filesize(@disk_free_space($path)) .'</span> free of <span class="badge badge-light">'.fm_get_filesize(@disk_total_space($path)).'</span>'; ?>
                        </td>
                    </tr>
                    </tfoot>
                    <?php
                }
                ?>
            </table>
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
