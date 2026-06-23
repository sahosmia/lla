<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Blog;
use App\Models\BlogCategoryLink;
use App\Models\BlogTag;
use App\Models\BlogTagLink;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run()
    {
        Blog::truncate();
        BlogCategoryLink::truncate();
        BlogTagLink::truncate();

        $storagePath = storage_path('app/public/blogs/');

        if (file_exists($storagePath)) {
            $files = glob($storagePath . '*'); // get all file names
            foreach ($files as $file) { // iterate files
                if (is_file($file)) {
                    unlink($file); // delete file
                }
            }
        }

        $blogs = [
            [
                'title' => "Pharma R&D's COVID-19 Scar that Goes Beyond Thoughts",
                'meta_title' => "Pharma R&D's Lasting Impact from COVID-19: Challenges Beyond Expectations",
                'meta_description' => "Discover how COVID-19 has left a lasting impact on pharmaceutical R&D, highlighting challenges and shifts in innovation, clinical trials, and drug development beyond initial expectations.",
                'description' => '<p>COVID-19 brought with it unprecedented challenges for R&D, including supply chain disruptions, a surge in demand for rapid solutions, and the pressure of working under uncertain conditions. Despite these challenges, the industry responded with remarkable speed, showcasing its adaptability.</p>' .
                    '<h2>Key Challenges Faced by Pharma R&D During COVID-19</h2>' .
                    '<ul>' .
                    '<li><strong>Supply Chain Disruptions</strong>: Access to crucial research materials was hindered.</li>' .
                    '<li><strong>Increased Collaboration</strong>: Collaboration among pharma companies and governments reached new heights.</li>' .
                    '<li><strong>Focus on Vaccines</strong>: A heightened focus on vaccine development and infectious diseases.</li>' .
                    '</ul>' .
                    '<blockquote>The COVID-19 pandemic has taught us invaluable lessons about adaptability and collaboration," says Dr. Emily Stone.</blockquote>' .
                    '<p>Moving forward, the pharmaceutical industry is expected to leverage the lessons learned during the pandemic to accelerate drug development and improve preparedness for future crises. Investment in technology, as well as fostering partnerships, will be key strategies.</p>' .
                    '<h3>What Lies Ahead?</h3>' .
                    '<p>"Looking ahead, pharma companies are increasingly investing in digital tools to enhance research capabilities. Technologies like AI and machine learning are being utilized to streamline research processes and predict outcomes more effectively."</p>' .
                    '<p>Moreover, <em>regulatory flexibility</em> during the pandemic has paved the way for quicker approval processes, which could be standardized in the future for certain critical medicines.</p>' .
                    '<h3>Lessons for the Future</h3>' .
                    '<p>The pandemic highlighted the need for rapid adaptability, collaboration, and investment in healthcare infrastructure. By building on these lessons, the industry can not only be better prepared for future crises but also ensure more resilient healthcare systems globally. The evolution of remote clinical trials and the adoption of digital health tools have become significant strides forward.</p>' .
                    '<p>In the long term, partnerships between governments, international organizations, and the pharmaceutical industry will remain crucial. The pandemic has shown the power of shared knowledge and resources in achieving breakthroughs at a rapid pace.</p>' .
                    '<h4>Impact on Regulatory Frameworks</h4>' .
                    '<p>Regulatory bodies have also learned from the COVID-19 pandemic, with several now considering more agile approval processes for treatments that address urgent health challenges. Streamlining these processes will be vital in ensuring that life-saving treatments reach patients more swiftly.</p>' .
                    '<p>Ultimately, COVID-19 has reshaped the landscape of pharmaceutical research and development, bringing about both challenges and significant opportunities for improvement.</p>' .
                    '<p>Pharmaceutical R&D is at a pivotal point where the lessons learned during the pandemic can be applied to future research endeavors. Investment in artificial intelligence and machine learning technologies is transforming the way drugs are discovered, tested, and brought to market. The key takeaway for the future is to maintain the momentum of adaptability and quick decision-making, which has already redefined the norms of pharma R&D.</p>' .
                    '<p>The implications of improved regulatory agility cannot be overstated. By reducing bureaucratic hurdles and promoting a cooperative approach, governments can significantly speed up the availability of innovative treatments. Additionally, the focus on improving supply chain resilience has led to new strategies that minimize disruptions. Cross-industry partnerships have emerged as a cornerstone of these resilience efforts, ensuring that all stakeholders work together towards common goals.</p>' .
                    '<p>As we navigate the future, the R&D sector must also focus on the mental well-being of researchers, who faced intense pressure during the pandemic. Ensuring support systems for mental health can lead to more effective and innovative teams. Furthermore, expanding the use of remote and virtual clinical trials has not only increased efficiency but has also allowed more diverse patient populations to participate, enhancing the quality of research outcomes.</p>',
                'category_ids'  => [2, 3],
                'tags'          => [1, 2, 3],
            ],
            [
                'title' => 'The Art of Overcoming Corporate Setbacks',
                'meta_title' => 'Mastering the Art of Overcoming Corporate Setbacks: Strategies for Success',
                'meta_description' => 'Learn effective strategies for overcoming corporate setbacks and turning challenges into opportunities for growth, resilience, and long-term success.',
                'description' => 'Corporate setbacks are inevitable, but how companies respond to them determines their resilience and long-term success. Every organization faces obstacles at some point—whether financial, operational, or market-driven—and navigating these effectively is the hallmark of strong leadership.</p>' .
                    '<h2>Common Corporate Challenges</h2>' .
                    '<ul>' .
                    '<li><strong>Financial Downturns</strong>: Periodic downturns that affect cash flow and profitability.</li>' .
                    '<li><strong>Leadership Challenges</strong>: Issues related to leadership and decision-making under pressure.</li>' .
                    '<li><strong>Market Shifts</strong>: Sudden changes in consumer behavior and market trends.</li>' .
                    '</ul>' .
                    '<blockquote>To overcome these obstacles, corporations must foster a culture of resilience and agility. Encouraging communication</blockquote>' .
                    '<p>True resilience is built by learning from failures and turning them into opportunities," - Cameron Williamson</p>' .
                    '<h3>Strategies for Resilience</h3>' .
                    '<p>Some effective strategies include investing in employee development, adopting flexible work models, and maintaining a strong focus on customer needs. Companies that prioritize these areas are better positioned to adapt to challenges.</p>' .
                    '<h3>The Importance of Leadership</h3>' .
                    '<p>Leadership plays a critical role in overcoming corporate setbacks. Effective leaders communicate transparently, provide support, and take decisive actions. By doing so, they inspire their teams to stay focused and work towards common goals even during challenging times.</p>' .
                    '<p>Moreover, leaders who show empathy and prioritize mental health foster a work culture that supports individuals during setbacks. Companies that provide a safety net for employees during tough times are more likely to emerge stronger once the challenges subside.</p>' .
                    '<h4>Innovation as a Catalyst for Growth</h4>' .
                    '<p>Setbacks can also be an opportunity to innovate. By rethinking current strategies and processes, companies can identify new avenues for growth and gain a competitive edge. For example, many businesses turned to digital transformation during the pandemic, unlocking new revenue streams and improving efficiency.</p>' .
                    '<p>Ultimately, setbacks are a natural part of corporate life, but those who see them as opportunities to learn and grow can position themselves for future success.</p>' .
                    '<p>In order to truly harness the power of setbacks, companies need to create an environment where employees are encouraged to take calculated risks. Failures should be seen as learning opportunities rather than end points. Embracing an agile approach to project management can also foster a culture that is flexible and ready to pivot when setbacks occur. This proactive approach ensures that companies remain resilient, even in the face of uncertainty.</p>' .
                    '<p>Moreover, understanding the importance of mental health support for employees during challenging times cannot be underestimated. By providing access to counseling services and promoting open dialogue about mental health, companies not only build resilience but also foster loyalty and long-term commitment from their workforce.</p>' .
                    '<p>Companies that thrive after setbacks are those that remain vigilant about external market shifts and adapt accordingly. Investing in upskilling and continuous learning for employees ensures that the workforce remains capable of handling new challenges as they arise. Developing contingency plans and having diversified revenue streams are additional measures that can safeguard against unexpected disruptions.</p>',
                'category_ids'  => [1, 2],
                'tags'          => [4, 5, 6],
            ],
            [
                'title' => 'Green Technology and Its Role in Sustainable Development',
                'meta_title' => 'Green Technology: Driving Sustainable Development for a Greener Future',
                'meta_description' => 'Explore how green technology is shaping sustainable development, promoting eco-friendly solutions, and driving a greener future for the planet.',
                'description' => '<p>Green technology is at the forefront of sustainable development, providing innovative solutions to reduce the environmental impact of human activities. The integration of eco-friendly practices is key to achieving a balance between development and environmental conservation.</p>' .
                    '<h2>Key Innovations in Green Tech</h2>' .
                    '<ul>' .
                    '<li><strong>Renewable Energy</strong>: Solar, wind, and hydro energy are becoming more cost-effective and widely adopted.</li>' .
                    '<li><strong>Electric Vehicles</strong>: The EV revolution is reducing dependency on fossil fuels.</li>' .
                    '<li><strong>Energy Efficiency</strong>: Innovations in reducing energy consumption across industries.</li>' .
                    '</ul>' .
                    '<blockquote>Sustainable development is not just an option; it is an imperative," - Jane Smith, Environmental Scientist</blockquote>' .
                    '<h3>The Road Ahead</h3>' .
                    '<p>Governments and private companies must work together to ensure that green technologies are accessible and affordable. Policies that incentivize the adoption of renewable energy and sustainable practices will play a crucial role in the years to come.</p>' .
                    '<h3>Public Awareness and Education</h3>' .
                    '<p>Another important factor in driving green technology adoption is public awareness. People need to understand the impact of their daily choices on the environment and be empowered to make sustainable decisions. Education campaigns and incentives can encourage individuals and businesses to adopt green practices.</p>' .
                    '<h4>Challenges in Scaling Green Technology</h4>' .
                    '<p>While renewable energy is growing rapidly, scalability remains a challenge. Many developing countries lack the infrastructure required to harness green technology. Investing in the development of green infrastructure, especially in underserved regions, is crucial to making sustainable development a global reality.</p>' .
                    '<p>Green technology is the way forward, and by making concerted efforts across industries and borders, we can ensure a greener, more sustainable future for generations to come.</p>' .
                    '<p>One of the primary challenges in the green technology space is affordability and accessibility, particularly for developing nations. Governments and international organizations must collaborate to bridge the gap between technological advancement and infrastructure limitations. By providing subsidies and financial support, renewable energy can become a more viable option globally, helping nations reduce their carbon footprints.</p>' .
                    '<p>In addition to investment, public-private partnerships are a powerful driver of green technology implementation. Many successful projects in renewable energy and green infrastructure have emerged due to collaboration between governments, private firms, and non-governmental organizations. These partnerships have demonstrated that shared responsibility can lead to innovative solutions that benefit society as a whole.</p>' .
                    '<p>Finally, education plays a critical role in the widespread adoption of green technologies. By incorporating sustainability into school curriculums and promoting awareness campaigns, future generations can grow up with an understanding of the importance of protecting the environment. Engaging with communities to educate them on the economic and social benefits of green practices will also drive long-term change.</p>',
                'category_ids' => [2, 3],
                'tags'  => [7, 8, 9],
            ],
            [
                'title' => 'The Future of AI in Customer Service',
                'meta_title' => 'AI in Customer Service: Enhancing Efficiency and Personalization',
                'meta_description' => 'Discover how AI is revolutionizing customer service, making it more efficient and personalized, and freeing up human agents to focus on complex issues.',
                'description' => '<p>AI is transforming customer service by making it more efficient and personalized. Companies are using AI-powered chatbots and virtual assistants to handle basic queries, freeing up human agents to focus on complex issues.</p>' .
                    '<h2>AI-Powered Solutions</h2>' .
                    '<ul>' .
                    '<li><strong>24/7 Availability</strong>: Chatbots and virtual assistants provide round-the-clock service.</li>' .
                    '<li><strong>Data-Driven Insights</strong>: AI can analyze customer data to provide tailored solutions.</li>' .
                    '<li><strong>Cost Reduction</strong>: Reducing the need for large call center teams.</li>' .
                    '</ul>' .
                    '<blockquote>Successful companies find a balance between automation and personalized human interaction.</blockquote>' .
                    '<p>AI should complement, not replace, human interactions in customer service," notes Sarah Johnson, Customer Experience Manager at a leading tech firm.</p>' .
                    '<h3>Balancing Automation and Personalization</h3>' .
                    '<p>Companies that effectively blend AI with human empathy are more likely to create positive customer experiences. This balance ensures customers receive efficient service while still feeling valued.</p>' .
                    '<h3>The Future of Customer Insights</h3>' .
                    '<p>AI is also being used to provide deeper insights into customer behavior. By analyzing patterns, companies can predict customer needs and offer solutions proactively. This ability to anticipate customer requirements will be a major differentiator in the future of customer service.</p>' .
                    '<h4>Building Trust in AI Systems</h4>' .
                    '<p>To make AI solutions successful, building trust is essential. Customers need to feel confident that their data is being used responsibly and that they can easily escalate issues to a human agent when needed. Transparency about how AI is used and ensuring data privacy are crucial steps in building this trust.</p>' .
                    '<p>AI is here to stay, but it will only thrive in customer service if human empathy remains at the core of interactions.</p>' .
                    '<p>The integration of AI and human support is becoming a significant factor in customer loyalty. By providing quick responses to common inquiries, AI tools allow human representatives to dedicate more time to complex problems, ensuring customers receive timely and efficient resolutions. This hybrid approach not only increases efficiency but also enhances the overall customer experience by maintaining a personal connection.</p>' .
                    '<p>Moreover, AI-driven insights can help companies identify emerging trends and respond to customer expectations more effectively. By analyzing customer data, companies can provide personalized recommendations and anticipate needs before they arise. The ability to proactively address issues and provide a personalized experience can significantly boost customer satisfaction and loyalty.</p>' .
                    '<p>Another crucial aspect of AI in customer service is ensuring data privacy and transparency. Companies must make sure that customer data is handled securely and that customers understand how their information is being used. By being transparent about data policies and providing clear escalation paths, companies can build a strong foundation of trust, which is essential for successful AI adoption in customer service.</p>',
                'category_ids'  => [1, 2],
                'tags'          => [10, 11, 12],
            ],
            [
                'title' => 'Balancing Work and Life in the Remote Era',
                'meta_title' => 'Remote Work: Tips for Maintaining a Healthy Work-Life Balance',
                'meta_description' => 'Discover how to balance work and life in the remote era, with tips for maintaining a healthy work-life balance and avoiding burnout.',
                'description' => '<p>The rise of remote work has brought both opportunities and challenges in maintaining a healthy work-life balance. The flexibility of working from home is empowering, but it requires discipline to avoid burnout.</p>' .
                    '<h2>Tips for Maintaining Balance</h2>' .
                    '<ul>' .
                    '<li><strong>Set Boundaries</strong>: Designate specific work hours and stick to them.</li>' .
                    '<li><strong>Create a Dedicated Workspace</strong>: Keep work-related activities confined to one area of your home.</li>' .
                    '<li><strong>Take Breaks</strong>: Avoid burnout by taking short breaks throughout the day.</li>' .
                    '</ul>' .
                    '<blockquote>Remote work offers flexibility but requires proactive effort to maintain productivity and well-being.</blockquote>' .
                    '<p>Establishing routines and boundaries is key to thriving in a remote work environment," says Dr. Marcus Lee, a work-life balance expert.</p>' .
                    '<h3>Building a Sustainable Remote Work Routine</h3>' .
                    '<p>Adopting practices like scheduled breaks, clear communication, and prioritizing mental health are crucial to success in the remote era. Employers should also provide resources to support remote workers in achieving this balance.</p>' .
                    '<p>Remote work can blur the lines between professional and personal life, making it essential to establish clear boundaries. Workers should have a designated workspace that helps separate work from leisure time. Setting up a specific area for work helps individuals mentally transition in and out of work mode, which can significantly enhance productivity and reduce stress levels.</p>' .
                    '<p>Another important aspect of maintaining balance is communication. Regular check-ins with managers and teammates can help employees feel connected and supported. Establishing a consistent communication routine can also help manage workloads more effectively, ensuring that remote workers are neither overburdened nor isolated.</p>' .
                    '<p>Employers also play a vital role in supporting remote work balance. Providing mental health resources, encouraging time off, and understanding the unique pressures of remote work are critical steps toward fostering a healthy remote work culture. Encouraging employees to disconnect after work hours and promoting a culture of respect for personal time can significantly impact overall well-being and job satisfaction.</p>',
                'category_ids'  => [5, 6],
                'tags'          => [13, 14, 15],
            ],
            [
                'title' => 'The Rise of Electric Vehicles in Urban Mobility',
                'meta_title' => 'Electric Vehicles: Driving Towards a Greener Urban Future',
                'meta_description' => 'Discover how electric vehicles are transforming urban mobility, reducing pollution, and promoting a more sustainable future.',
                'description' => '<p>Electric vehicles (EVs) are becoming a key part of the future of urban mobility. With growing concerns about pollution and fossil fuels, EVs provide a cleaner, more sustainable mode of transport.</p>' .
                    '<h2>Challenges in EV Adoption</h2>' .
                    '<ul>' .
                    '<li><strong>Charging Infrastructure</strong>: Expanding charging networks is crucial for widespread adoption.</li>' .
                    '<li><strong>Range Anxiety</strong>: Overcoming consumer fears about the distance EVs can travel on a single charge.</li>' .
                    '<li><strong>Battery Sustainability</strong>: The need for sustainable battery production and recycling methods.</li>' .
                    '</ul>' .
                    '<blockquote>Despite these challenges, governments and private sectors are making significant investments in EV infrastructure.</blockquote>' .
                    '<p>The transition to electric vehicles is a critical step towards reducing urban pollution," notes John Doe, an urban mobility analyst.</p>' .
                    '<h3>Driving Towards a Greener Future</h3>' .
                    '<p>Public-private partnerships and continued innovation in battery technology are essential to making EVs accessible and practical for all. With these efforts, the dream of cleaner urban environments can become a reality.</p>' .
                    '<p>The expansion of charging infrastructure is a key component in supporting the rise of electric vehicles. Governments and private companies are working together to increase the number of charging stations in urban and rural areas, making EVs more practical for everyday use. Innovations in fast-charging technology are also addressing consumer concerns over long charging times, helping to ease the transition to electric vehicles.</p>' .
                    '<p>Battery technology remains one of the most crucial aspects of EV adoption. Advances in battery storage capacity and the development of more sustainable battery materials are making electric vehicles more efficient and environmentally friendly. The focus on recycling used batteries is also a critical factor in minimizing the environmental impact of increased EV adoption.</p>' .
                    '<p>In addition to technological advancements, government incentives such as tax breaks and subsidies are playing a major role in encouraging the adoption of electric vehicles. By making EVs more affordable, these incentives are helping to accelerate the shift towards greener urban mobility. Consumer awareness and education campaigns are also crucial in promoting the benefits of electric vehicles and helping potential buyers understand their long-term cost savings and environmental advantages.</p>',
                'category_ids'  => [5, 6],
                'tags'          => [16, 17, 18],
            ],
            [
                'title' => 'Mental Health Awareness in the Workplace',
                'meta_title' => 'Mental Health in the Workplace: Building a Resilient Workforce',
                'meta_description' => 'Discover how mental health awareness is transforming workplaces, promoting a more resilient and productive workforce.',
                'description' => '<p>Mental health awareness is gaining traction in the corporate world as companies recognize the importance of employee well-being.</p>' .
                    '<h2>Key Components of Mental Health Support</h2>' .
                    '<ul>' .
                    '<li><strong>Open Dialogue</strong>: Encouraging employees to discuss mental health without stigma.</li>' .
                    '<li><strong>Access to Support</strong>: Providing access to counseling and other support services.</li>' .
                    '<li><strong>Preventing Burnout</strong>: Promoting policies that prevent burnout and ensure employees have time to recharge.</li>' .
                    '</ul>' .
                    '<blockquote>Investing in mental health is an investment in your workforce," says Dr. Marcus Lee, a psychologist.</blockquote>' .
                    '<h3>Building a Supportive Work Culture</h3>' .
                    '<p>Companies that foster a culture of openness and provide resources for mental health can expect a more resilient and productive workforce. Policies like flexible work hours, mental health days, and comprehensive benefits are key components of this approach.</p>' .
                    '<p>Creating an environment where mental health is openly discussed is one of the first steps toward building a supportive workplace. Encouraging conversations about well-being, reducing stigma around mental health issues, and training leaders to recognize signs of stress and burnout can significantly impact the well-being of employees. Employees who feel supported are more likely to be engaged and productive, contributing positively to the organization.</p>' .
                    '<p>Access to professional mental health support is another critical component. Companies can offer counseling services, either in-house or through partnerships with external providers, to ensure that employees have access to the help they need. Employers can also provide mental health resources, such as workshops, wellness apps, and educational materials, to help employees proactively manage their well-being.</p>' .
                    '<p>Preventing burnout requires a multi-faceted approach that includes workload management, adequate rest periods, and policies that encourage work-life balance. Promoting flexible working hours, allowing mental health days, and encouraging the use of vacation days can help employees recharge and maintain their well-being. When companies take active steps to support mental health, they not only enhance productivity but also create a more positive and sustainable work culture.</p>',
                'category_ids'  => [2, 3],
                'tags'          => [19, 20, 21],
            ],
            [
                'title' => 'The Importance of Cybersecurity in Modern Businesses',
                'meta_title' => 'Cybersecurity: Protecting Sensitive Information in the Digital Age',
                'meta_description' => 'Discover how cybersecurity is crucial for modern businesses, ensuring sensitive information is protected and maintaining trust and credibility.',
                'description' => '<p>As more businesses move their operations online, cybersecurity has become a critical concern. Ensuring sensitive information is protected is essential for maintaining trust and credibility.</p>' .
                    '<h2>Cybersecurity Best Practices</h2>' .
                    '<ul>' .
                    '<li><strong>Data Protection</strong>: Ensuring sensitive information is kept secure.</li>' .
                    '<li><strong>Staff Training</strong>: Educating staff on recognizing and preventing cyber threats.</li>' .
                    '<li><strong>Incident Response</strong>: Having a clear plan in place to respond to data breaches and other incidents.</li>' .
                    '</ul>' .
                    '<blockquote>Strong cybersecurity practices are the backbone of modern business integrity," says Alan Brown, cybersecurity expert.</blockquote>' .
                    '<h3>Staying Ahead of Threats</h3>' .
                    '<p>Companies must continuously update their security protocols and train employees to recognize potential threats. Partnering with cybersecurity firms can also provide the expertise needed to mitigate risks effectively.</p>' .
                    '<p>As cyber threats evolve, it is crucial for businesses to stay one step ahead by implementing strong data protection measures. Encryption of sensitive data, secure storage solutions, and access controls are essential practices to safeguard against unauthorized access. Companies must also regularly review their data security measures to identify potential vulnerabilities and address them proactively.</p>' .
                    '<p>Staff training is a key element in preventing cybersecurity breaches. Employees should be educated on how to recognize phishing attempts, create strong passwords, and follow best practices when handling company data. Regular workshops and training sessions can significantly reduce the likelihood of successful cyber attacks, as well-informed employees are less likely to fall for common scams.</p>' .
                    '<p>In addition, having a well-prepared incident response plan is essential for mitigating the damage caused by any cyber attack. This plan should include steps for containment, eradication, and recovery, as well as communication strategies for notifying stakeholders. By practicing incident response through regular drills, companies can ensure that their teams are ready to act quickly and effectively in the event of a breach, minimizing damage and restoring normal operations as swiftly as possible.</p>',
                'category_ids'  => [1, 2],
                'tags'          => [22, 23, 24],
            ],
            [
                'title' => 'Challenges and Opportunities in Digital Marketing',
                'meta_title' => 'Digital Marketing: Navigating Challenges and Opportunities',
                'meta_description' => 'Discover how digital marketing is evolving, with challenges and opportunities for businesses aiming to connect with customers online.',
                'description' => '<p>The digital marketing landscape is constantly evolving, presenting both challenges and opportunities for businesses aiming to connect with customers online.</p>' .
                    '<h2>Key Challenges in Digital Marketing</h2>' .
                    '<ul>' .
                    '<li><strong>Social Media Dynamics</strong>: Leveraging social media platforms for targeted ad campaigns.</li>' .
                    '<li><strong>Content Creation</strong>: Creating valuable content remains at the heart of digital strategies.</li>' .
                    '<li><strong>Data Utilization</strong>: Using data to understand customer behavior and improve campaign effectiveness.</li>' .
                    '</ul>' .
                    '<blockquote>In digital marketing, those who adapt quickly are the ones who thrive," says Karen White, a digital marketing strategist.</blockquote>' .
                    '<h3>Embracing Innovation</h3>' .
                    '<p>Successful digital marketers use the latest tools to analyze data, understand trends, and refine their strategies. Embracing change and keeping a customer-centric focus are key to achieving digital marketing success.</p>' .
                    '<p>The dynamic nature of social media is one of the biggest challenges in digital marketing. Platforms like Facebook, Instagram, and TikTok constantly evolve their algorithms, which can impact the visibility of content. Marketers need to stay on top of these changes to ensure their campaigns reach the intended audience. Engaging content that resonates with users is essential to capture attention and drive engagement.</p>' .
                    '<p>Content creation continues to be a driving force behind digital marketing success. Businesses that provide valuable, informative, and engaging content are more likely to attract and retain customers. Video content, blogs, infographics, and interactive media are all effective ways to deliver messages that resonate with audiences. Brands that consistently produce high-quality content build trust and authority in their industry.</p>' .
                    '<p>Utilizing data is another major opportunity in digital marketing. By leveraging analytics tools, marketers can gain insights into customer behavior, preferences, and pain points. These insights enable businesses to tailor their campaigns for maximum effectiveness, ensuring that messages are relevant and well-targeted. Understanding the metrics behind campaign performance is crucial for making data-driven decisions that improve future marketing efforts.</p>',
                'category_ids'  => [6],
                'tags'          => [25, 26, 27],
            ],
        ];

        foreach ($blogs as $index => $blog) {


            $blogCreatd = Blog::create([
                'author_id'             => User::first()->id,
                'title'                 => $blog['title'],
                'meta_title'            => $blog['meta_title'],
                'meta_description'      => $blog['meta_description'],
                'slug'                  => Str::slug($blog['title']),
                'description'           => $blog['description'],
                'image'                 => $this->addImage($index + 1),
                'status'                => 'published',
                'created_at' => now(),
                'updated_at' => now(),
            ]);


            $blogCreatd->categories()->attach($blog['category_ids']);
            $blogCreatd->tags()->attach($blog['tags']);
        }
    }

    private function addImage($index)
    {
        $imageName = Str::random(30) . '.png';

        if (!File::exists(storage_path('app/public/blogs'))) {
            File::makeDirectory(storage_path('app/public/blogs'), 0755, true, true);
        }

        Storage::disk(getStorageDisk())->putFileAs('blogs', public_path('demo-content/blogs/' . $index . '.png'), $imageName);

        return 'blogs/' . $imageName;
    }
}
