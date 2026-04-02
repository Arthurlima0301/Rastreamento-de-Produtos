## D.E.R 


```bash
Table insumos {
  id int [pk, increment]
  codigo_insumo varchar
  nome varchar
  unidade_medida varchar
}

Table nota_fiscal {
  id int [pk, increment]
  codigo_nf varchar
}

Table item {
  id int [pk, increment]
  numero int
  nota_fiscal_id int
  item_id int
  quantidade int
}

Table saidas {
  id int [pk, increment]
  data datetime
  quantidade int
}

Table saidas_insumos {
  id int [pk, increment]
  saida_id int
  insumo_id int
}

Ref: item.nota_fiscal_id > nota_fiscal.id
Ref: item.item_id > insumos.id

Ref: "saidas"."id" < "saidas_insumos"."saida_id"
Ref: "item"."item_id" < "saidas_insumos"."insumo_id"

```