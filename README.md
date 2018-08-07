## 安装说明
1、发布配置：
```php
php aratisan vendor:publish
```
> 选择`configure-server` 和 `OkamiChen\ConfigureServer\ServerServiceProvider` 发布

2、更新数据库

```php
php aratisan migrate
```

## 集成Laravel-Admin

### 路由
1、分组管理
`/module/confiurge/server/node`
2、配置管理
`/module/confiurge/server/group`
> 记得加上`laravel-admin`的路由前缀

