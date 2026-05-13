<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Process;
use App\Models\AiSubpoint;
use App\Models\AiStatistic;
use App\Models\UseCase;
use App\Models\UseCaseTag;
use App\Models\Workflow;
use App\Models\Industry;
use App\Models\IndustryFeature;
use App\Models\Feature;
use App\Models\FeaturePoint;
use App\Models\Blog;
use App\Models\FaqCategory;
use App\Models\Faq;
use App\Models\Project;
use App\Models\ProjectFeature;

class DemoContentSeeder extends Seeder
{
    public function run(): void
    {
        // ── How It Works (Processes) ──
        $processes = [
            ['title' => ['en' => 'Connect', 'ar' => 'الاتصال'], 'description' => ['en' => 'Seamlessly integrate your existing data sources — databases, APIs, cloud storage, and enterprise platforms — in minutes, not months.', 'ar' => 'قم بدمج مصادر بياناتك الحالية بسلاسة في دقائق وليس أشهر.']],
            ['title' => ['en' => 'Transform', 'ar' => 'التحويل'], 'description' => ['en' => 'Our AI agents automatically clean, normalize, and enrich your raw data into analysis-ready datasets with zero manual intervention.', 'ar' => 'يقوم وكلاء الذكاء الاصطناعي لدينا بتنظيف وتحويل بياناتك تلقائياً.']],
            ['title' => ['en' => 'Analyze', 'ar' => 'التحليل'], 'description' => ['en' => 'Deploy pre-built or custom AI models that surface hidden patterns, predict trends, and generate actionable business intelligence.', 'ar' => 'انشر نماذج ذكاء اصطناعي مخصصة للكشف عن الأنماط والتنبؤ بالاتجاهات.']],
            ['title' => ['en' => 'Act', 'ar' => 'التنفيذ'], 'description' => ['en' => 'Turn insights into automated workflows — trigger alerts, generate reports, and drive decisions across your organization in real time.', 'ar' => 'حوّل الرؤى إلى سير عمل آلي يقود القرارات في الوقت الفعلي.']],
        ];
        foreach ($processes as $p) { Process::create($p); }

        // ── Agentic AI Sub-Points ──
        $subpoints = [
            ['title' => ['en' => 'Autonomous Decision Making', 'ar' => 'اتخاذ القرارات المستقل'], 'description' => ['en' => 'AI agents that independently analyze situations, weigh options, and execute optimal decisions without human bottlenecks.', 'ar' => 'وكلاء ذكاء اصطناعي يحللون المواقف ويتخذون القرارات المثلى بشكل مستقل.']],
            ['title' => ['en' => 'Multi-Agent Collaboration', 'ar' => 'التعاون متعدد الوكلاء'], 'description' => ['en' => 'Specialized agents work together, sharing context and coordinating tasks to solve complex enterprise challenges.', 'ar' => 'وكلاء متخصصون يعملون معاً لحل التحديات المؤسسية المعقدة.']],
            ['title' => ['en' => 'Continuous Learning', 'ar' => 'التعلم المستمر'], 'description' => ['en' => 'Agents evolve with your business — learning from outcomes, adapting strategies, and improving performance over time.', 'ar' => 'وكلاء يتطورون مع عملك ويتعلمون من النتائج ويحسنون الأداء باستمرار.']],
        ];
        foreach ($subpoints as $sp) { AiSubpoint::create($sp); }

        // ── AI Statistics ──
        $stats = [
            ['value' => '50+', 'label' => ['en' => 'AI Agents Deployed', 'ar' => 'وكيل ذكاء اصطناعي تم نشره']],
            ['value' => '99.7%', 'label' => ['en' => 'Uptime Guarantee', 'ar' => 'ضمان وقت التشغيل']],
            ['value' => '3×', 'label' => ['en' => 'Faster Insights', 'ar' => 'رؤى أسرع']],
            ['value' => '40%', 'label' => ['en' => 'Cost Reduction', 'ar' => 'تقليل التكاليف']],
        ];
        foreach ($stats as $s) { AiStatistic::create($s); }

        // ── Use Cases ──
        $useCases = [
            ['title' => ['en' => 'Data Quality Agent', 'ar' => 'وكيل جودة البيانات'], 'description' => ['en' => 'Automatically detects anomalies, fills missing values, and ensures data consistency across all your pipelines.', 'ar' => 'يكتشف الشذوذ تلقائياً ويضمن اتساق البيانات.'], 'tags' => ['Data Cleaning', 'Anomaly Detection', 'ETL']],
            ['title' => ['en' => 'Predictive Analytics Agent', 'ar' => 'وكيل التحليلات التنبؤية'], 'description' => ['en' => 'Forecasts business metrics using advanced ML models trained on your historical data patterns.', 'ar' => 'يتنبأ بمقاييس الأعمال باستخدام نماذج تعلم آلي متقدمة.'], 'tags' => ['Forecasting', 'ML Models', 'Time Series']],
            ['title' => ['en' => 'Report Generation Agent', 'ar' => 'وكيل إنشاء التقارير'], 'description' => ['en' => 'Creates executive dashboards and detailed reports with natural language summaries, delivered on schedule.', 'ar' => 'ينشئ لوحات معلومات تنفيذية وتقارير مفصلة مع ملخصات بلغة طبيعية.'], 'tags' => ['Dashboards', 'NLP', 'Automation']],
        ];
        foreach ($useCases as $uc) {
            $tags = $uc['tags']; unset($uc['tags']);
            $model = UseCase::create($uc);
            foreach ($tags as $t) { UseCaseTag::create(['use_case_id' => $model->id, 'tag' => ['en' => $t, 'ar' => $t]]); }
        }

        // ── Workflows ──
        $workflows = [
            ['title' => ['en' => 'Ingest', 'ar' => 'الاستيعاب'], 'subtitle' => ['en' => 'Pull data from any source', 'ar' => 'سحب البيانات من أي مصدر'], 'order' => 0],
            ['title' => ['en' => 'Process', 'ar' => 'المعالجة'], 'subtitle' => ['en' => 'Clean and transform data', 'ar' => 'تنظيف وتحويل البيانات'], 'order' => 1],
            ['title' => ['en' => 'Enrich', 'ar' => 'الإثراء'], 'subtitle' => ['en' => 'Add context with AI models', 'ar' => 'إضافة سياق مع نماذج الذكاء الاصطناعي'], 'order' => 2],
            ['title' => ['en' => 'Deliver', 'ar' => 'التسليم'], 'subtitle' => ['en' => 'Push insights to stakeholders', 'ar' => 'تقديم الرؤى لأصحاب المصلحة'], 'order' => 3],
        ];
        foreach ($workflows as $w) { Workflow::create($w); }

        // ── Industries ──
        $industries = [
            ['title' => ['en' => 'Government', 'ar' => 'الحكومة'], 'tagline' => ['en' => 'Smart governance through data', 'ar' => 'حوكمة ذكية من خلال البيانات'], 'description' => ['en' => 'Empower government agencies with AI-driven insights for policy making, citizen services, and operational efficiency.', 'ar' => 'تمكين الجهات الحكومية بالرؤى المدعومة بالذكاء الاصطناعي.'], 'color' => '#3B82F6', 'features' => ['Policy Analytics', 'Citizen Insights', 'Resource Optimization']],
            ['title' => ['en' => 'Banking & Finance', 'ar' => 'البنوك والمالية'], 'tagline' => ['en' => 'Intelligent financial operations', 'ar' => 'عمليات مالية ذكية'], 'description' => ['en' => 'Transform banking operations with real-time fraud detection, risk assessment, and personalized customer experiences.', 'ar' => 'تحويل العمليات المصرفية مع كشف الاحتيال في الوقت الفعلي.'], 'color' => '#10B981', 'features' => ['Fraud Detection', 'Risk Analytics', 'Customer Intelligence']],
            ['title' => ['en' => 'Healthcare', 'ar' => 'الرعاية الصحية'], 'tagline' => ['en' => 'Data-driven patient care', 'ar' => 'رعاية المرضى المبنية على البيانات'], 'description' => ['en' => 'Leverage health data to improve patient outcomes, optimize hospital operations, and accelerate clinical research.', 'ar' => 'استفد من البيانات الصحية لتحسين نتائج المرضى.'], 'color' => '#EF4444', 'features' => ['Patient Analytics', 'Clinical Insights', 'Operational Efficiency']],
            ['title' => ['en' => 'Real Estate', 'ar' => 'العقارات'], 'tagline' => ['en' => 'Smart property intelligence', 'ar' => 'ذكاء عقاري متقدم'], 'description' => ['en' => 'Make smarter investment decisions with market trend analysis, property valuation models, and demand forecasting.', 'ar' => 'اتخذ قرارات استثمارية أذكى مع تحليل اتجاهات السوق.'], 'color' => '#F59E0B', 'features' => ['Market Analysis', 'Valuation Models', 'Demand Forecasting']],
            ['title' => ['en' => 'Retail & E-commerce', 'ar' => 'التجزئة والتجارة الإلكترونية'], 'tagline' => ['en' => 'Personalized shopping experiences', 'ar' => 'تجارب تسوق مخصصة'], 'description' => ['en' => 'Drive revenue with AI-powered recommendations, inventory optimization, and customer behavior analytics.', 'ar' => 'زيادة الإيرادات مع التوصيات المدعومة بالذكاء الاصطناعي.'], 'color' => '#8B5CF6', 'features' => ['Recommendation Engine', 'Inventory AI', 'Customer Segmentation']],
            ['title' => ['en' => 'Energy & Utilities', 'ar' => 'الطاقة والمرافق'], 'tagline' => ['en' => 'Optimized energy operations', 'ar' => 'عمليات طاقة محسّنة'], 'description' => ['en' => 'Optimize energy production, predict equipment failures, and manage grid operations with intelligent automation.', 'ar' => 'تحسين إنتاج الطاقة والتنبؤ بأعطال المعدات.'], 'color' => '#06B6D4', 'features' => ['Predictive Maintenance', 'Grid Analytics', 'Consumption Forecasting']],
        ];
        foreach ($industries as $ind) {
            $features = $ind['features']; unset($ind['features']);
            $model = Industry::create($ind);
            foreach ($features as $f) { IndustryFeature::create(['industry_id' => $model->id, 'key' => ['en' => $f, 'ar' => $f]]); }
        }

        // ── Why BotJourney (Features) ──
        $features = [
            ['title' => ['en' => 'Lightning Fast Deployment', 'ar' => 'نشر سريع كالبرق'], 'stat_value' => '3', 'stat_suffix' => ['en' => '×', 'ar' => '×'], 'stat_description' => ['en' => 'Faster than traditional implementations', 'ar' => 'أسرع من التطبيقات التقليدية'], 'points' => ['Zero-downtime migrations', 'Pre-built connectors for 100+ sources', 'Automated testing and validation']],
            ['title' => ['en' => 'Enterprise Security', 'ar' => 'أمان المؤسسات'], 'stat_value' => '99.9', 'stat_suffix' => ['en' => '%', 'ar' => '%'], 'stat_description' => ['en' => 'Uptime with SOC2 compliance', 'ar' => 'وقت تشغيل مع الامتثال لمعايير SOC2'], 'points' => ['End-to-end encryption', 'Role-based access control', 'Full audit trail']],
            ['title' => ['en' => 'Cost Efficiency', 'ar' => 'كفاءة التكلفة'], 'stat_value' => '40', 'stat_suffix' => ['en' => '%', 'ar' => '%'], 'stat_description' => ['en' => 'Average cost reduction for clients', 'ar' => 'متوسط تقليل التكاليف للعملاء'], 'points' => ['Pay-per-use pricing model', 'No upfront infrastructure costs', 'Reduced manual labor hours']],
        ];
        foreach ($features as $f) {
            $points = $f['points']; unset($f['points']);
            $model = Feature::create($f);
            foreach ($points as $pt) { FeaturePoint::create(['feature_id' => $model->id, 'key' => ['en' => $pt, 'ar' => $pt]]); }
        }

        // ── Blog Posts ──
        $blogs = [
            ['title' => ['en' => 'The Rise of Agentic AI in Enterprise Data', 'ar' => 'صعود الذكاء الاصطناعي الوكيلي في بيانات المؤسسات'], 'content' => ['en' => 'Discover how autonomous AI agents are transforming the way enterprises handle data pipelines, from ingestion to insight delivery.', 'ar' => 'اكتشف كيف يحوّل وكلاء الذكاء الاصطناعي المستقلون طريقة تعامل المؤسسات مع خطوط البيانات.'], 'read_time' => '6 min read'],
            ['title' => ['en' => 'Saudi Arabia Vision 2030: Data-Driven Transformation', 'ar' => 'رؤية المملكة 2030: التحول المبني على البيانات'], 'content' => ['en' => 'How BotJourney is helping Saudi organizations align their data strategies with the ambitious goals of Vision 2030.', 'ar' => 'كيف تساعد بوت جيرني المؤسسات السعودية في مواءمة استراتيجيات البيانات مع أهداف رؤية 2030.'], 'read_time' => '8 min read'],
            ['title' => ['en' => '5 Signs Your Data Pipeline Needs an AI Upgrade', 'ar' => '5 علامات تدل على أن خط بياناتك يحتاج إلى ترقية بالذكاء الاصطناعي'], 'content' => ['en' => 'Manual ETL processes, data quality issues, and slow time-to-insight are key indicators your pipeline is ready for AI automation.', 'ar' => 'عمليات ETL اليدوية ومشاكل جودة البيانات هي مؤشرات رئيسية على أن خط بياناتك جاهز للأتمتة.'], 'read_time' => '5 min read'],
            ['title' => ['en' => 'Building Trust in AI: Explainability and Governance', 'ar' => 'بناء الثقة في الذكاء الاصطناعي: الشفافية والحوكمة'], 'content' => ['en' => 'Enterprise AI adoption requires transparency. Learn how explainable AI and robust governance frameworks build stakeholder confidence.', 'ar' => 'يتطلب تبني الذكاء الاصطناعي في المؤسسات الشفافية. تعرف على كيفية بناء ثقة أصحاب المصلحة.'], 'read_time' => '7 min read'],
        ];
        foreach ($blogs as $b) { Blog::create($b); }

        // ── FAQ Categories & Questions ──
        $faqData = [
            ['title' => ['en' => 'General', 'ar' => 'عام'], 'description' => ['en' => 'Common questions about BotJourney', 'ar' => 'أسئلة شائعة حول بوت جيرني'], 'faqs' => [
                ['question' => ['en' => 'What is BotJourney?', 'ar' => 'ما هي بوت جيرني؟'], 'answer' => ['en' => 'BotJourney is an enterprise data intelligence platform that uses agentic AI to automate data workflows, generate insights, and drive business decisions across industries.', 'ar' => 'بوت جيرني هي منصة ذكاء بيانات مؤسسية تستخدم الذكاء الاصطناعي الوكيلي لأتمتة سير عمل البيانات.']],
                ['question' => ['en' => 'Which industries do you serve?', 'ar' => 'ما هي الصناعات التي تخدمونها؟'], 'answer' => ['en' => 'We serve Government, Banking & Finance, Healthcare, Real Estate, Retail, and Energy sectors — with a strong focus on the Middle East and Saudi Arabia.', 'ar' => 'نخدم قطاعات الحكومة والبنوك والرعاية الصحية والعقارات والتجزئة والطاقة مع تركيز قوي على الشرق الأوسط.']],
            ]],
            ['title' => ['en' => 'Technical', 'ar' => 'تقني'], 'description' => ['en' => 'Technical questions about our platform', 'ar' => 'أسئلة تقنية حول منصتنا'], 'faqs' => [
                ['question' => ['en' => 'How long does integration take?', 'ar' => 'كم يستغرق التكامل؟'], 'answer' => ['en' => 'Most integrations are completed within 2-4 weeks. Our pre-built connectors support 100+ data sources out of the box.', 'ar' => 'يتم إكمال معظم عمليات التكامل في غضون 2-4 أسابيع.']],
                ['question' => ['en' => 'Is my data secure?', 'ar' => 'هل بياناتي آمنة؟'], 'answer' => ['en' => 'Absolutely. We use end-to-end encryption, are SOC2 compliant, and offer on-premises deployment options for maximum data sovereignty.', 'ar' => 'بالتأكيد. نستخدم التشفير من طرف إلى طرف ونلتزم بمعايير SOC2.']],
            ]],
            ['title' => ['en' => 'Pricing', 'ar' => 'الأسعار'], 'description' => ['en' => 'Questions about plans and pricing', 'ar' => 'أسئلة حول الخطط والأسعار'], 'faqs' => [
                ['question' => ['en' => 'Do you offer a free trial?', 'ar' => 'هل تقدمون تجربة مجانية؟'], 'answer' => ['en' => 'Yes, we offer a 14-day free trial with full access to all platform features. No credit card required.', 'ar' => 'نعم، نقدم تجربة مجانية لمدة 14 يوماً مع وصول كامل لجميع ميزات المنصة.']],
                ['question' => ['en' => 'What pricing models are available?', 'ar' => 'ما هي نماذج التسعير المتاحة؟'], 'answer' => ['en' => 'We offer flexible pay-per-use pricing and enterprise annual plans. Contact our sales team for a custom quote tailored to your needs.', 'ar' => 'نقدم أسعاراً مرنة بنظام الدفع حسب الاستخدام وخطط سنوية للمؤسسات.']],
            ]],
        ];
        foreach ($faqData as $cat) {
            $faqs = $cat['faqs']; unset($cat['faqs']);
            $category = FaqCategory::create($cat);
            foreach ($faqs as $faq) { Faq::create(array_merge($faq, ['category_id' => $category->id])); }
        }

        // ── Projects ──
        $govId = Industry::where('title->en', 'Government')->first()?->id;
        $bankId = Industry::where('title->en', 'Banking & Finance')->first()?->id;
        $healthId = Industry::where('title->en', 'Healthcare')->first()?->id;

        $projects = [
            ['industry_id' => $govId, 'title' => ['en' => 'National Data Governance Platform', 'ar' => 'منصة حوكمة البيانات الوطنية'], 'description' => ['en' => 'Built a comprehensive data governance platform for a Saudi government ministry, unifying 40+ data sources into a single intelligence layer with real-time dashboards and automated compliance reporting.', 'ar' => 'بناء منصة شاملة لحوكمة البيانات لوزارة حكومية سعودية.'], 'outcome_value' => '60%', 'outcome_label' => ['en' => 'Faster decision-making', 'ar' => 'اتخاذ قرارات أسرع'], 'color' => '#3B82F6', 'features' => ['Unified data lake', 'Real-time dashboards', 'Automated compliance']],
            ['industry_id' => $bankId, 'title' => ['en' => 'AI-Powered Fraud Detection System', 'ar' => 'نظام كشف الاحتيال بالذكاء الاصطناعي'], 'description' => ['en' => 'Deployed an intelligent fraud detection system for a leading Saudi bank, processing 2M+ transactions daily with 99.8% accuracy and reducing false positives by 75%.', 'ar' => 'نشر نظام ذكي لكشف الاحتيال لبنك سعودي رائد.'], 'outcome_value' => '75%', 'outcome_label' => ['en' => 'Reduction in false positives', 'ar' => 'تقليل الإيجابيات الكاذبة'], 'color' => '#10B981', 'features' => ['Real-time scoring', 'ML models', 'Alert automation']],
            ['industry_id' => $healthId, 'title' => ['en' => 'Clinical Analytics Dashboard', 'ar' => 'لوحة التحليلات السريرية'], 'description' => ['en' => 'Created a clinical analytics platform for a hospital network, enabling predictive patient flow management and resource optimization across 12 facilities.', 'ar' => 'إنشاء منصة تحليلات سريرية لشبكة مستشفيات.'], 'outcome_value' => '35%', 'outcome_label' => ['en' => 'Improvement in patient throughput', 'ar' => 'تحسين في إنتاجية المرضى'], 'color' => '#EF4444', 'features' => ['Patient flow prediction', 'Resource optimization', 'KPI tracking']],
        ];
        foreach ($projects as $proj) {
            $feats = $proj['features']; unset($proj['features']);
            $model = Project::create($proj);
            foreach ($feats as $f) { ProjectFeature::create(['project_id' => $model->id, 'key' => ['en' => $f, 'ar' => $f]]); }
        }
    }
}
