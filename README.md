## PHP 类库

## 项目结构
```
.
├── docs                     # 文档目录
├── src                      # 源代码
│   ├── App                  # 业务（框架）代码
│   │   ├── Interfaces       # 接口类
│   │   └── Yii              # Yii 框架具体实现
│   ├── Common               # 类库公共模块（如：配置）
│   ├── Libs                 # 封装的类库
│   ├── Utils                # 封装的常用方法
│   └── JMD.php              # 类库主入口，用于初始化环境
└── tests                    # 单元测试
```