# Set up the shop project

Setting up the shop project is only necessary if you have access to the Gitlab repository. This access must be
requested separately. If you don't have access, you can directly start developing your modules based on a full version.

If you have access to the shops Gitlab repository, you can login at
[https://sources.gambio-server.net](https://sources.gambio-server.net).


## Create a fork of the shop project

To create a [fork](https://de.wikipedia.org/wiki/Abspaltung_%28Softwareentwicklung%29) for your module development,
you need to follow these steps:

* Navigate to **[this page](https://sources/gambio/gxdev)** (you may need to log in).
* Create a fork of the project by clicking on the **Fork** button (located in the upper right corner).
* Assign the fork to yourself by clicking on your username.


## Clone your fork locally

Now you can clone the created fork for local development. To do this, you need to access your fork in Gitlab and then
choose between cloning the fork via SSH or HTTPS. The advantage of SSH over HTTPS is that you don't have to enter your
username and password every time you *push* a change.

However, to create a clone using SSH, an SSH key has to be created first. You can read more about this
[here](https://sources.gambio-server.net/help/ssh/README).

Now you can finally create a local clone of your fork. For this you have to do the following:

* Call up your fork in Gitlab.
* Click on the **Clone** button in the upper right corner.
* Copy the content from the **SSH** input field; this is the Git repository address.
* Open a terminal and navigate to your desired destination directory (e.g. the directory of your local webserver).

Now enter the following command:
```sh
> git clone GIT-ADRESS
```

`GIT-ADRESS` corresponds to the git repository address, you just copied.

After cloning your fork, you are in the default branch. In general, the default branch is always the latest version
we are working on. If you want to change the branch, you can do so with the following command:

```sh
> git checkout BRANCHNAME
```

`BRANCHNAME` corresponds to the desired branch.

Ideally, we recommend using one of our release branches or release tags (version tag) for development. This way,
you make sure your development base corresponds to a real shop version.


## Set up the shop project

Before you can develop within the shop, you first have to install the required dependencies. You can do this with the
following commands:

```sh
> yarn install
> yarn build:dev
```

This process may take a few minutes. Once the process is complete, you can upload the project files to your
web server (or copy them to an equivalent directory) and access the shop.

!!! Info "Notice"
    Instead of the command `yarn build:dev` you can also use the command `yarn setup:dev`. Using the last command, the
    StyleEdit 4 will not be built, so that executing this command is much faster.
