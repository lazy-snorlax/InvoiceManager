echo '==> Composer Install'
composer install
echo '==> Patching Build code'
cp propel/Column.php  vendor/propel/propel/src/Propel/Generator/Model/Column.php
# cp propel/SqlsrvAdapter.php vendor/propel/propel/src/Propel/Runtime/Adapter/Pdo/SqlsrvAdapter.php
echo '==> Build dbclasses'
vendor/bin/propel model:build
echo '==> Build Conifg'
vendor/bin/propel config:convert
# echo '==> Fixing spaces in fieldnames'
# ./fixspaces.sh
# echo '==> Override Map classes'
# ./insertMapOverrides.sh
echo '==> Dump Autoload'
composer dumpautoload