maintainer        "Opscode, Inc."
maintainer_email  "cookbooks@opscode.com"
license           "Apache 2.0"
description       "Installs and maintains php and php modules"
version           "1.0.0"

depends "build-essential"
depends "xml"
depends "mysql"

%w{ debian ubuntu centos redhat fedora }.each do |os|
  supports os
end

recipe "php-fcgi", "Installs php-fcgi"
