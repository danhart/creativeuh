Vagrant::Config.run do |config|
  # All Vagrant configuration is done here. The most common configuration
  # options are documented and commented below. For a complete reference,
  # please see the online documentation at vagrantup.com.

  # Every Vagrant virtual environment requires a box to build off of.
  config.vm.box = "dans-dev-box"

  # The url from where the 'config.vm.box' box will be fetched if it
  # doesn't already exist on the user's system.
  config.vm.box_url = "http://www.thedanish.co.uk/dans-dev.box"

  # Boot with a GUI so you can see the screen. (Default is headless)
  # config.vm.boot_mode = :gui

  # Assign this VM to a host only network IP, allowing you to access it
  # via the IP.
  config.vm.network "33.33.33.50"

  # Forward a port from the guest to the host, which allows for outside
  # computers to access the VM, whereas host only networking does not.
  config.vm.forward_port "http", 80, 1340

  # Share an additional folder to the guest VM. The first argument is
  # an identifier, the second is the path on the guest to mount the
  # folder, and the third is the path on the host to the actual folder.
  config.vm.share_folder "v-site", "/website", "site/", :nfs => true
  config.vm.share_folder "v-zf", "/usr/local/ZendFramework", "/usr/local/ZendFramework/", :nfs => true

  # Enable provisioning with chef solo, specifying a cookbooks path (relative
  # to this Vagrantfile), and adding some recipes and/or roles.
  #
  config.vm.provision :chef_solo do |chef|
    chef.cookbooks_path = "cookbooks"
    chef.add_recipe "main"
    # chef.add_role "web"

    # You may also specify custom JSON attributes:   
    # chef.json = { :mysql_password => "foo" }
    chef.json.merge!({
      :mysql => {
        :server_root_password => "vagrant",
        :server_repl_password => "vagrant",
        :server_debian_password => "vagrant"
      }
    })
  end
end
