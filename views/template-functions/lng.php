<?php
/**
 * Language Translation System
 * @param string $txt
 * @return string
 */
function lng($txt) {
    global $lang;

    // English Language
    $tr['en']['AppName']        = 'Tiny File Manager';      $tr['en']['AppTitle']           = 'File Manager';
    $tr['en']['Login']          = 'Sign in';                $tr['en']['Username']           = 'Username';
    $tr['en']['Password']       = 'Password';               $tr['en']['Logout']             = 'Sign Out';
    $tr['en']['Move']           = 'Move';                   $tr['en']['Copy']               = 'Copy';
    $tr['en']['Save']           = 'Save';                   $tr['en']['SelectAll']          = 'Select all';
    $tr['en']['UnSelectAll']    = 'Unselect all';           $tr['en']['File']               = 'File';
    $tr['en']['Back']           = 'Back';                   $tr['en']['Size']               = 'Size';
    $tr['en']['Perms']          = 'Perms';                  $tr['en']['Modified']           = 'Modified';
    $tr['en']['Owner']          = 'Owner';                  $tr['en']['Search']             = 'Search';
    $tr['en']['NewItem']        = 'New Item';               $tr['en']['Folder']             = 'Folder';
    $tr['en']['Delete']         = 'Delete';                 $tr['en']['Rename']             = 'Rename';
    $tr['en']['CopyTo']         = 'Copy to';                $tr['en']['DirectLink']         = 'Direct link';
    $tr['en']['UploadingFiles'] = 'Upload Files';           $tr['en']['ChangePermissions']  = 'Change Permissions';
    $tr['en']['Copying']        = 'Copying';                $tr['en']['CreateNewItem']      = 'Create New Item';
    $tr['en']['Name']           = 'Name';                   $tr['en']['AdvancedEditor']     = 'Advanced Editor';
    $tr['en']['RememberMe']     = 'Remember Me';            $tr['en']['Actions']            = 'Actions';
    $tr['en']['Upload']         = 'Upload';                 $tr['en']['Cancel']             = 'Cancel';
    $tr['en']['InvertSelection']= 'Invert Selection';       $tr['en']['DestinationFolder']  = 'Destination Folder';
    $tr['en']['ItemType']       = 'Item Type';              $tr['en']['ItemName']           = 'Item Name';
    $tr['en']['CreateNow']      = 'Create Now';             $tr['en']['Download']           = 'Download';
    $tr['en']['Open']           = 'Open';                   $tr['en']['UnZip']              = 'UnZip';
    $tr['en']['UnZipToFolder']  = 'UnZip to folder';        $tr['en']['Edit']               = 'Edit';
    $tr['en']['NormalEditor']   = 'Normal Editor';          $tr['en']['BackUp']             = 'Back Up';
    $tr['en']['SourceFolder']   = 'Source Folder';          $tr['en']['Files']              = 'Files';
    $tr['en']['Move']           = 'Move';                   $tr['en']['Change']             = 'Change';
    $tr['en']['Settings']       = 'Settings';               $tr['en']['Language']           = 'Language';
    $tr['en']['MemoryUsed']     = 'Memory used';            $tr['en']['PartitionSize']      = 'Partition size';
    $tr['en']['ErrorReporting'] = 'Error Reporting';        $tr['en']['ShowHiddenFiles']    = 'Show Hidden Files';

    $i18n = fm_get_translations($tr);
    $tr = $i18n ? $i18n : $tr;

    if (!strlen($lang)) $lang = 'en';
    if (isset($tr[$lang][$txt])) return fm_enc($tr[$lang][$txt]);
    else if (isset($tr['en'][$txt])) return fm_enc($tr['en'][$txt]);
    else return "$txt";
}
