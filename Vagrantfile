Vagrant.configure("2") do |config|
    config.vm.box = "ubuntu/jammy64"
    config.vm.network "private_network", ip: "192.168.56.10"

    config.vm.provider "virtualbox" do |vb|
      vb.memory = "2048"
      vb.cpus = 2
    end

    # Mount the apps directories
    config.vm.synced_folder "./apps/php-todo", "/var/www/php-todo"
    config.vm.synced_folder "./apps/node-todo", "/var/www/node-todo"
    #config.vm.provision "shell", path: "init-venv-ansible-target.sh"
  end