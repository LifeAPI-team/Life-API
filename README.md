# Life-API
This plugin is MinecraftBE::PMMP Economyplugin.  

## How to use

### 日本語
このPluginは経済API・pluginです。このpluginではAPIを使用して様々な操作が可能です。  
- 必須use文
```
use apart\LifeAPI\LifeAPI;
```
- Playerの所持金を取得する
```
LifeAPI::getInstance()->mymoney($name);
```
- Playerの所持金を追加する
```
LifeAPI::getInstance()->addmoney($name,$money);
```
- Playerの所持金を指定分削除する
```
LifeAPI::getInstance()->removemoney($name,$money);
```

### Thanks!
rain1208様  
tachan様  
