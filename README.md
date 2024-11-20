# Development Environment Setup

This repository contains a complete development environment setup for running two todo applications:
1. PHP Todo App (CodeIgniter)
2. NodeJS Todo App (Express)

## Prerequisites

- Vagrant
- VirtualBox
- Ansible

## Installation

1. Install the required tools:

```bash
# Ubuntu/Pop!_OS
sudo apt update
sudo apt install vagrant virtualbox ansible

# MacOS
brew install vagrant virtualbox ansible
```

2. Clone this repository:
```bash
git clone https://github.com/sayyidyofa/grafana-poc
cd grafana-poc
```

3. Add local DNS entries (the ip address is according to `inventory/hosts.yml`):
```bash
# Add to /etc/hosts
192.168.56.10 phptodo.local
192.168.56.10 reacttodo.local
```

4. Start the development environment:
```bash
vagrant up
ansible-playbook -i inventory/hosts.yml playbooks/site.yml
```

## Accessing the Applications

- PHP Todo App: http://phptodo.local
- React Todo App: http://nodetodo.local

## Directory Structure

```
.
├── Vagrantfile
├── apps/
│   ├── php-todo/
│   └── node-todo/
├── inventory/
│   └── hosts.yml
├── playbooks/
│   └── site.yml
```

## Development Workflow

1. The applications' source code is mounted into the VM, so you can edit the code on your host machine using your preferred IDE.
2. Changes to the apps will be reflected immediately.
## Database Access

MariaDB is configured with the following credentials:

(PHP app)

- Database: db_todolist
- Username: todouser_php
- Password: todo_password_php

(Node app)

- Database: tododb
- Username: todouser
- Password: todopass

You can connect to the database using:
```bash
vagrant ssh
mysql -u todouser -ptodopass tododb
```

## Troubleshooting

1. If you can't access the sites, make sure you've added the entries to your /etc/hosts file
2. If Vagrant can't start the VM, ensure VirtualBox is properly installed and virtualization is enabled in your BIOS
3. For database connection issues, verify the credentials in the application configurations match those in the Ansible playbook

## Contributing

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a new Pull Request