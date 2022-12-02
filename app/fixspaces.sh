echo '==> Patching Map Classes'
echo '==> Patching Tablebusinessdetail'
sed -i 's/\COL_[[]BUSINESS ID]/\COL_BUSINESS_ID/' ./src/dbclasses/Map/TablebusinessdetailTableMap.php
sed -i 's/\COL_[[]BUSINESS NAME]/\COL_BUSINESS_NAME/' ./src/dbclasses/Map/TablebusinessdetailTableMap.php
sed -i 's/\COL_[[]CONTACT NAME]/\COL_CONTACT_NAME/' ./src/dbclasses/Map/TablebusinessdetailTableMap.php
sed -i 's/\COL_[[]AFTER HOURS1]/\COL_AFTER_HOURS1/' ./src/dbclasses/Map/TablebusinessdetailTableMap.php
sed -i 's/\COL_[[]EMAIL ADDRESS1]/\COL_EMAIL_ADDRESS1/' ./src/dbclasses/Map/TablebusinessdetailTableMap.php
sed -i 's/\COL_[[]POST CODE1]/\COL_POST_CODE1/' ./src/dbclasses/Map/TablebusinessdetailTableMap.php
sed -i 's/\COL_[[]POST CODE2]/\COL_POST_CODE2/' ./src/dbclasses/Map/TablebusinessdetailTableMap.php

sed -i 's/\COL_[[]BUSINESS ID]/\COL_BUSINESS_ID/' ./src/dbclasses/Base/Tablebusinessdetail.php
sed -i 's/\COL_[[]BUSINESS NAME]/\COL_BUSINESS_NAME/' ./src/dbclasses/Base/Tablebusinessdetail.php
sed -i 's/\COL_[[]CONTACT NAME]/\COL_CONTACT_NAME/' ./src/dbclasses/Base/Tablebusinessdetail.php
sed -i 's/\COL_[[]AFTER HOURS1]/\COL_AFTER_HOURS1/' ./src/dbclasses/Base/Tablebusinessdetail.php
sed -i 's/\COL_[[]EMAIL ADDRESS1]/\COL_EMAIL_ADDRESS1/' ./src/dbclasses/Base/Tablebusinessdetail.php
sed -i 's/\COL_[[]POST CODE1]/\COL_POST_CODE1/' ./src/dbclasses/Base/Tablebusinessdetail.php
sed -i 's/\COL_[[]POST CODE2]/\COL_POST_CODE2/' ./src/dbclasses/Base/Tablebusinessdetail.php

sed -i 's/\COL_[[]BUSINESS ID]/\COL_BUSINESS_ID/' ./src/dbclasses/Base/TablebusinessdetailQuery.php
sed -i 's/\COL_[[]BUSINESS NAME]/\COL_BUSINESS_NAME/' ./src/dbclasses/Base/TablebusinessdetailQuery.php
sed -i 's/\COL_[[]CONTACT NAME]/\COL_CONTACT_NAME/' ./src/dbclasses/Base/TablebusinessdetailQuery.php
sed -i 's/\COL_[[]AFTER HOURS1]/\COL_AFTER_HOURS1/' ./src/dbclasses/Base/TablebusinessdetailQuery.php
sed -i 's/\COL_[[]EMAIL ADDRESS1]/\COL_EMAIL_ADDRESS1/' ./src/dbclasses/Base/TablebusinessdetailQuery.php
sed -i 's/\COL_[[]POST CODE1]/\COL_POST_CODE1/' ./src/dbclasses/Base/TablebusinessdetailQuery.php
sed -i 's/\COL_[[]POST CODE2]/\COL_POST_CODE2/' ./src/dbclasses/Base/TablebusinessdetailQuery.php


# echo '==> Patching TablebusinessdetailTableMap'
