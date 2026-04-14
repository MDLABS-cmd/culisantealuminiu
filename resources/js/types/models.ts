export type BaseModel = {
    id: number;
    created_at: string;
    updated_at: string;
};

export type Accesory = BaseModel & {
    name: string;
    price: string;
    active: boolean;
};

export type Color = BaseModel & {
    color_category_id: number;
    name: string;
    hex_code: string;
    code: string;
    active: boolean;
};

export type ColorCategory = BaseModel & {
    name: string;
    active: boolean;
    order: number;
};

export type Dimension = BaseModel & {
    schema_id: number;
    width: number;
    height: number;
    active: boolean;
};

export type DimensionPricing = BaseModel & {
    dimension_id: number;
    material_id: number;
    material_cost: number;
    working_hours: number;
    working_cost: number;
    price_without_vat: number;
    additional_cost: number;
};

export type File = BaseModel & {
    fileable_id: number;
    fileable_type: string;
    name: string;
    path: string;
    mime_type: string;
    size: number;
    type: string;
    disk: string;
    collection: string;
};

export type Handle = BaseModel & {
    name: string;
    type: string;
    price: string;
    active: boolean;
};

export type Material = BaseModel & {
    name: string;
    active: boolean;
    order: number;
};

export type Schema = BaseModel & {
    system_id: number;
    material_id: number;
    name: string;
    price_type: string;
    order: number;
    active: boolean;
};

export type System = BaseModel & {
    name: string;
    is_custom: boolean;
    active: boolean;
    order: number;
};

export type AccesoryWithSchemas = Accesory & {
    schemas: Schema[];
};

export type ColorWithCategory = Color & {
    category: ColorCategory;
};

export type ColorCategoryWithSystems = ColorCategory & {
    systems: System[];
};

export type ColorCategoryWithColors = ColorCategory & {
    colors: Color[];
};

export type DimensionWithSchema = Dimension & {
    schema: Schema;
};

export type DimensionWithPricing = Dimension & {
    pricing: DimensionPricing | null;
};

export type DimensionPricingWithDimension = DimensionPricing & {
    dimension: Dimension;
};

export type DimensionPricingWithMaterial = DimensionPricing & {
    material: Material;
};

export type FileWithFileable = File & {
    fileable: Schema;
};

export type MaterialWithSchemas = Material & {
    schemas: Schema[];
};

export type SchemaWithSystem = Schema & {
    system: System;
};

export type SchemaWithMaterial = Schema & {
    material: Material;
};

export type SchemaWithDimensions = Schema & {
    dimensions: Dimension[];
};

export type SchemaWithAccesories = Schema & {
    accesories: Accesory[];
};

export type SchemaWithFiles = Schema & {
    files: File[];
};

export type SystemWithColorCategories = System & {
    colorCategories: ColorCategory[];
};
