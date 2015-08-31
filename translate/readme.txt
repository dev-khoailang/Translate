1. edit your configuration in top of file application/config/config.php 

2. edit database connection in application/config/database.php

3. import file AmazonBrowseTreeTranslate.sql, It will replace your old table AmazonBrowseTreeTranslate (remove your old table first)

4. run script
php index.php welcome/index/$source_language/$target_language/$page

example
php index.php welcome/index/es/fr/0
- will translate from ES to FR, start with page 1
