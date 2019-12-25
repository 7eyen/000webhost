# ftp deploy

项目提交后自动部署到ftp

### 如何使用 
在`Your_Project/.github/workflows/main.yml`中添加以下代码

```yaml
on: push

jobs:
  FTP-Deploy-Action:
    name: FTP-Deploy-Action
    runs-on: ubuntu-latest
    steps:
    - uses: actions/checkout@master
      with:
        fetch-depth: 2
    - name: 部署到远程服务器
      uses: 7eyen/000webhost@deploy
      env:
        FTP_SERVER: ftp://your.domian.com/
        FTP_USERNAME: myFtpUserName
        FTP_PASSWORD: ${{ secrets.FTP_PASSWORD }}
```

1. 选择你要同步的仓库
2. 选择`actions`选项卡
3. 选择`Set up a workflow yourself`或者手动创建`Your_Project/.github/workflows/main.yml`文件
4. 粘贴上面的代码到文件并保存
5. 在项目的`Setting`->`Secret`中添加`FTP_PASSWORD`

| 配置项 | 是否必须 | 参考值                           | 描述                                                      |
| :----------- | :------: | -------------------------------- | --------------------------------------------------------- |
| `FTP_SERVER` |    是    | ftp://ftp.yourdomian.com:21/path | 要部署项目的ftp地址，端口（不设置默认使用21）和`path`为可选项 |
| `FTP_USERNAME` |    是    | test                             | 你的ftp账户名                                             |
| `FTP_PASSWORD` |    是    | test                             | 你的ftp密码                                               |
| `ARGS`       |    否    | [参考拓展配置](###拓展配置)      | 自定义git-ftp参数，此字段直接传递到git-ftp脚本中          |

### 拓展配置

| `ARGS`              | 描述                                                         |
| :------------------ | ------------------------------------------------------------ |
| `--disable-epsv`    | 禁用EPSV模式，改用PASV模式（如果你的服务器不支持EPSV，请附加这个选项） |
| `--verbose`         | 输出调试信息                                                 |
| `--syncroot [path]` | 指定一个本地目录进行同步，相对于git项目的根目录(./path)      |
| --all               | 不进行比较，直接传输所有文件                                 |
| 更多可选项          | 请参考[git-ftp](https://github.com/git-ftp/git-ftp/blob/master/man/git-ftp.1.md) |

### 在同步中忽略指定文件

项目中添加`.git-ftp-ignore`，用`shell glob`格式添加你需要排除的文件和文件夹

#### 忽略git相关文件

```gitattributes
.gitignore
*/.gitignore
*/.gitkeep
.git-ftp-ignore
.git-ftp-include
.gitlab-ci.yml
```

#### 忽略文件名为`example.txt`文件

```gitattributes
example.txt
```

#### 忽略`.txt`后缀文件
```gitattributes
*.txt
```

#### 忽略`config`文件夹下的所有内容
```gitattributes
config/*
```

### 同步未跟踪的文件

.git-ftp-include文件指定Git-ftp应该上载的故意未跟踪的文件。 如果您有应始终上传的文件，请添加以！开头的行。

#### 指定单一文件`VERSION.txt`

```gitattributes
!VERSION.txt
```

#### 如果在某文件变更时想同步指定目录

如果您使用像composer这样的软件包管理器，则可以在composer.lock文件更改时上载所有软件包。

```gitattributes
vendor/:composer.lock
```

