# Development Environment Setup

This repository contains a complete development environment setup for running two todo applications:
1. PHP Todo App (CodeIgniter)
2. React/Express Todo App

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
git clone <your-repo-url>
cd <repo-directory>
```

3. Create the directory structure:
```bash
mkdir -p apps/php-todo apps/react-todo
```

4. Clone the PHP todo app:
```bash
git clone https://github.com/sayyidyofa/codeigniter-todolist apps/php-todo
```

5. Copy the React todo app files into apps/react-todo

6. Add local DNS entries:
```bash
# Add to /etc/hosts
192.168.56.10 phptodo.local
192.168.56.10 reacttodo.local
```

7. Start the development environment:
```bash
vagrant up
ansible-playbook -i inventory/hosts.yml playbooks/site.yml
```

## Accessing the Applications

- PHP Todo App: http://phptodo.local
- React Todo App: http://reacttodo.local

## Directory Structure

```
.
├── Vagrantfile
├── ansible.cfg
├── apps/
│   ├── php-todo/
│   └── react-todo/
├── inventory/
│   └── hosts.yml
├── playbooks/
│   └── site.yml
└── templates/
    ├── nginx-php-todo.conf.j2
    └── nginx-react-todo.conf.j2
```

## Development Workflow

1. The applications' source code is mounted into the VM, so you can edit the code on your host machine using your preferred IDE.
2. Changes to the PHP app will be reflected immediately.
3. For the React app, you'll need to rebuild after changes:
   ```bash
   vagrant ssh
   cd /var/www/react-todo
   npm run build
   ```

## Database Access

MariaDB is configured with the following credentials:
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