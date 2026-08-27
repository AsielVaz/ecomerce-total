<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            ['Tecnología', 'Audífonos Nimbus Pro', 'DTO-TEC-001', 2499, 2999, 24, true, 'Audio envolvente, cancelación activa de ruido y hasta 32 horas de batería.', 'Escucha cada detalle con drivers de alta fidelidad, modo ambiente y almohadillas de espuma viscoelástica diseñadas para acompañarte todo el día.', 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=1200&q=80'],
            ['Tecnología', 'Smartwatch Pulse X', 'DTO-TEC-002', 3199, 3799, 18, true, 'Salud, notificaciones y entrenamiento en una pantalla AMOLED ultrabrillante.', 'Registra sueño, frecuencia cardiaca y más de 100 modos deportivos. Resistente al agua y con autonomía para una semana completa.', 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=1200&q=80'],
            ['Tecnología', 'Teclado Atlas Mechanical', 'DTO-TEC-003', 1899, null, 12, false, 'Formato compacto, switches táctiles e iluminación configurable.', 'Construcción sólida de aluminio, conexión USB-C y teclas PBT para escribir, crear y jugar con precisión durante años.', 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?auto=format&fit=crop&w=1200&q=80'],
            ['Hogar', 'Cafetera Aurora', 'DTO-HOG-001', 1599, 1999, 30, true, 'Café intenso y consistente con diseño compacto para cualquier cocina.', 'Prepara hasta diez tazas, programa el inicio automático y conserva la temperatura sin sacrificar el sabor.', 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?auto=format&fit=crop&w=1200&q=80'],
            ['Hogar', 'Sillón Nórdico Cloud', 'DTO-HOG-002', 6999, 7999, 7, false, 'Comodidad profunda, líneas limpias y tapizado suave de alta resistencia.', 'Una pieza versátil con estructura reforzada y cojines de densidad equilibrada para descansar o recibir visitas.', 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?auto=format&fit=crop&w=1200&q=80'],
            ['Moda', 'Mochila Urban Shift', 'DTO-MOD-001', 1299, 1599, 40, true, 'Organización inteligente y protección acolchada para laptop de 15 pulgadas.', 'Tela repelente al agua, cierres suaves y múltiples bolsillos para acompañar el trabajo, la escuela o un viaje corto.', 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?auto=format&fit=crop&w=1200&q=80'],
            ['Moda', 'Tenis Velocity One', 'DTO-MOD-002', 2199, 2599, 22, false, 'Ligereza, soporte y amortiguación para moverte todo el día.', 'Suela flexible de gran tracción y tejido transpirable en una silueta limpia que funciona dentro y fuera del gimnasio.', 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=1200&q=80'],
            ['Belleza', 'Ritual Glow Essentials', 'DTO-BEL-001', 899, 1099, 35, true, 'Tres pasos esenciales para limpiar, hidratar y proteger la piel.', 'Fórmulas ligeras para uso diario con ingredientes hidratantes y texturas agradables, presentadas en un set listo para regalar.', 'https://images.unsplash.com/photo-1556228578-8c89e6adf883?auto=format&fit=crop&w=1200&q=80'],
            ['Belleza', 'Secadora Air Studio', 'DTO-BEL-002', 1799, null, 16, false, 'Secado rápido con control de temperatura y acabado brillante.', 'Motor de alto flujo, tecnología iónica y tres accesorios para adaptar el resultado a diferentes tipos de cabello.', 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?auto=format&fit=crop&w=1200&q=80'],
            ['Deportes', 'Tapete Balance Pro', 'DTO-DEP-001', 749, 899, 48, false, 'Superficie antideslizante y soporte cómodo para cada postura.', 'Material de alta densidad fácil de limpiar, con grosor equilibrado para yoga, movilidad y entrenamiento funcional.', 'https://images.unsplash.com/photo-1592432678016-e910b452f9a2?auto=format&fit=crop&w=1200&q=80'],
            ['Deportes', 'Botella Terra 950', 'DTO-DEP-002', 599, null, 60, false, 'Acero inoxidable, aislamiento térmico y tapa antiderrames.', 'Mantiene tus bebidas frías hasta 24 horas y calientes hasta 12, con un acabado resistente pensado para acompañarte.', 'https://images.unsplash.com/photo-1602143407151-7111542de6e8?auto=format&fit=crop&w=1200&q=80'],
            ['Gaming', 'Control Nova Wireless', 'DTO-GAM-001', 1499, 1799, 20, true, 'Respuesta precisa, agarre cómodo y conexión inalámbrica estable.', 'Joysticks de alta precisión, vibración ajustable y batería recargable para sesiones largas en PC y dispositivos compatibles.', 'https://images.unsplash.com/photo-1600080972464-8e5f35f63d08?auto=format&fit=crop&w=1200&q=80'],
        ];

        foreach ($products as [$categoryName, $name, $sku, $price, $compareAtPrice, $stock, $featured, $shortDescription, $description, $imageUrl]) {
            $category = Category::query()->where('name', $categoryName)->firstOrFail();

            Product::query()->updateOrCreate(
                ['sku' => $sku],
                [
                    'category_id' => $category->id,
                    'name' => $name,
                    'slug' => Str::slug($name),
                    'short_description' => $shortDescription,
                    'description' => $description,
                    'price' => $price,
                    'compare_at_price' => $compareAtPrice,
                    'stock' => $stock,
                    'image_url' => $imageUrl,
                    'is_featured' => $featured,
                    'is_active' => true,
                ],
            );
        }
    }
}
