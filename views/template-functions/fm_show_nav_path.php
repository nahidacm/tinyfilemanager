<?php
/**
 * Show nav block
 * @param string $path
 */
function fm_show_nav_path($path)
{
    global $lang, $sticky_navbar;
    $isStickyNavBar = $sticky_navbar ? 'fixed-top' : '';
    ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-white mb-4 main-nav <?php echo $isStickyNavBar ?>">
        <a class="navbar-brand" href=""> <?php echo lng('AppTitle') ?> </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <?php
            $path = fm_clean_path($path);
            $root_url = "<a href='?p='><i class='fa fa-home' aria-hidden='true' title='" . FM_ROOT_PATH . "'></i></a>";
            $sep = '<i class="bread-crumb"> / </i>';
            if ($path != '') {
                $exploded = explode('/', $path);
                $count = count($exploded);
                $array = array();
                $parent = '';
                for ($i = 0; $i < $count; $i++) {
                    $parent = trim($parent . '/' . $exploded[$i], '/');
                    $parent_enc = urlencode($parent);
                    $array[] = "<a href='?p={$parent_enc}'>" . fm_enc(fm_convert_win($exploded[$i])) . "</a>";
                }
                $root_url .= $sep . implode($sep, $array);
            }
            echo '<div class="col-xs-6 col-sm-5">' . $root_url . '</div>';
            ?>

            <div class="col-xs-6 col-sm-7 text-right">
                <ul class="navbar-nav mr-auto float-right">
                    <?php if (!FM_READONLY): ?>
                        <li class="nav-item mr-2">
                            <div class="input-group input-group-sm mr-1" style="margin-top:4px;">
                                <input type="text" class="form-control" placeholder="<?php echo lng('Search') ?>" aria-label="<?php echo lng('Search') ?>" aria-describedby="search-addon2" id="search-addon">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="search-addon2"><i class="fa fa-search"></i></span>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a title="<?php echo lng('Upload') ?>" class="nav-link" href="?p=<?php echo urlencode(FM_PATH) ?>&amp;upload"><i class="fa fa-cloud-upload" aria-hidden="true"></i> <?php echo lng('Upload') ?></a>
                        </li>
                        <li class="nav-item">
                            <a title="<?php echo lng('NewItem') ?>" class="nav-link" href="#createNewItem" data-toggle="modal" data-target="#createNewItem"><i class="fa fa-plus-square"></i> <?php echo lng('NewItem') ?></a>
                        </li>
                    <?php endif; ?>
                    <?php if (FM_USE_AUTH): ?>
                        <li class="nav-item avatar dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-user-circle"></i> <?php if(isset($_SESSION[FM_SESSION_ID]['logged'])) { echo $_SESSION[FM_SESSION_ID]['logged']; } ?></a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink-5">
                                <?php if (!FM_READONLY): ?>
                                    <a title="<?php echo lng('Settings') ?>" class="dropdown-item nav-link" href="?p=<?php echo urlencode(FM_PATH) ?>&amp;settings=1"><i class="fa fa-cog" aria-hidden="true"></i> <?php echo lng('Settings') ?></a>
                                <?php endif ?>
                                <a title="<?php echo lng('Help') ?>" class="dropdown-item nav-link" href="?p=<?php echo urlencode(FM_PATH) ?>&amp;help=2"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> <?php echo lng('Help') ?></a>
                                <a title="<?php echo lng('Logout') ?>" class="dropdown-item nav-link" href="?logout=1"><i class="fa fa-sign-out" aria-hidden="true"></i> <?php echo lng('Logout') ?></a>
                            </div>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <?php
}
