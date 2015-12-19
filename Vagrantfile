# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant::configure("2") do |config|

  config.vm.define "spring", autostart: false do |spring|
    spring.vm.provider :virtualbox do |vb|
      # Set configuration options for the VirtualBox image.
      vb.customize ["modifyvm", :id, "--memory", "2048", "--cpus", "2", "--ioapic", "on"]
    end
    spring.vm.box = "ubuntu/trusty64"
    spring.vm.hostname = "springconsult.loc"
    if Vagrant::Util::Platform.windows?
      spring.vm.provider :virtualbox do |vb|
        # Set configuration options for the VirtualBox image.
        vb.customize ["setextradata", :id, "VBoxInternal2/SharedFoldersEnableSymlinksCreate//vagrant","1"]
      end
      spring.vm.synced_folder ".", "/var/www/springconsult.loc", :mount_options => ["dmode=777","fmode=777"], :owner => "vagrant", :group => "vagrant"
    else
      spring.vm.synced_folder ".", "/var/www/springconsult.loc", :nfs => { :mount_options => ["dmode=777","fmode=777"] }
    end
    spring.vm.network :private_network, ip: "192.168.50.77"

    # Run this scripts after image was runned for the first time.
    spring.vm.provision :shell, path: "vagrant/shell/web.sh"
  end
end