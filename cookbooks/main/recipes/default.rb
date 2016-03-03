require_recipe "locale-gen"

require_recipe "apt"

apt_repository "dotdeb" do
      uri "http://packages.dotdeb.org"
      components ["stable","all"]
      action :add
end

require_recipe "openssl"

require_recipe "mysql::server"

require_recipe "php"

require_recipe "php-fcgi"

require_recipe "nginx"
