<?php

//namespace App\Helpers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\User;
use App\Models\UserAnswer;
use App\Models\CategoryStrength;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

if (!function_exists('getResponse')) {
    function getResponse($data, $token, $message, $status): array
    {
        $responseResults = [
            'data' => $data,
            'token' => $token,
            'message' => $message,
            'status' => $status,
        ];
        return $responseResults;
    }
}
if (!function_exists('apiResponse')) {
    /**
     * Return a standardized API response.
     *
     * @param string $apimessage
     * @param mixed  $apidata
     * @param bool   $apistatusFlag
     * @param int    $apihttpStatus
     * @param string|null $token
     * @return JsonResponse
     */
    function apiResponse(string $apimessage, $apidata = [], bool $apistatusFlag = true, int $apihttpStatus = 200, string $token = null): JsonResponse
    {
        return response()->json([
            'data'    => $apidata,
            'status'  => $apistatusFlag,
            'message' => $apimessage,
            'token'   => $token,
        ], $apihttpStatus);
    }
}

function _userCannot(string|array ...$permissions): bool
{
    $permissions = Arr::flatten($permissions);

    return !Auth::user()->can($permissions);
}
function _permissionErrorMessage(): string
{
    return __('You don`t have permission to perform this task.');
}

function sendOtp($user)
{
    $currentTime = Carbon::now();
    $expiresAt = $user->two_factor_expires_at ? Carbon::parse($user->two_factor_expires_at) : null;

    if ($expiresAt && $currentTime->lessThan($expiresAt)) {
        return [
            'success' => false,
            'message' => "OTP has already been sent. Please wait {$expiresAt->diffInSeconds($currentTime)} seconds before requesting again.",
            'status' => 429
        ];
    }

    $otp = random_int(100000, 999999);
    $user->update([
        'two_factor_code' => $otp,
        'two_factor_expires_at' => $currentTime->addMinutes(1), // OTP valid for 1 minute
    ]);

    return [
        'success' => true,
        'otp' => $otp,
        'status' => 201,
        'message' => "OTP has been sent to your email."
    ];
}

function getUserTree($UserID, $level, $manager)
{
    $user = User::where(function ($query) use ($UserID, $level, $manager) {
        $query->where('manager_id', $UserID)
            ->orWhere('level', $level)
            ->orWhere('id', $manager);
    })
        ->where('id', '!=', Auth::id())
        ->get();

    return $user;
}

function getUserLevel($UserID)
{
    $user = User::where('id', $UserID)->firstOrFail();

    return $user->level;
}

function getSocialMirrorScores($userId, $surveyId, $userLevel)
{
    $scores = UserAnswer::selectRaw('questions.category_id, categories.name as category_name, AVG(user_answers.answer) as average_score')
        ->join('questions', 'user_answers.question_id', '=', 'questions.id')
        ->join('categories', 'questions.category_id', '=', 'categories.id')
        ->where('user_answers.for_user_id', $userId)
        ->where('user_answers.survey_id', $surveyId)
        ->where('questions.type', 'stakeholder') // social mirror (360°)
        ->where('questions.level', $userLevel) // match the evaluated user's level
        ->groupBy('questions.category_id', 'categories.name')
        ->get();

    return response()->json($scores);
}

function getUserCategoryWithDescription($category)
{
    return CategoryStrength::where('category', $category)->where('type', 'strength')->firstOrFail();
}
function getUserCategoryWithWeaknessDescription($category)
{
    return CategoryStrength::where('category', $category)->where('type', 'weakness')->firstOrFail();
}

function generateComment($label, $score, $type, $score2 = null, $selfRank = null, $peerRank = null, $gapType = null, $gapText = null, $ordinalSuffix = '', $peerSuffix = '', $performanceLevel = '')
{
    if ($score) {
        $mean = ($score + $score2) / 2;
    }

    $textResponsibility = '';
    $textHonesty = '';
    $textEmpathy = '';
    $textHumility = '';
    $textPatience = '';

    $stakeholderResponsibility = '';
    $stakeholderHonesty = '';
    $stakeholderEmpathy = '';
    $stakeholderHumility = '';
    $stakeholderPatience = '';

    $summaryResponsibility = '';
    $summaryHonesty = '';
    $summaryEmpathy = '';
    $summaryHumility = '';
    $summaryPatience = '';

    if ($label === 'Responsibility and Accountability' && $type === 'self') {
        if ($score >= 90 && $score <= 100) {
            $textResponsibility = "You rated yourself at <strong>{$score}%</strong>, which reflects an exceptional sense of ownership and dependability. This indicates that you strongly identify yourself as someone who follows through with consistency and holds yourself accountable for your actions.";
        } elseif ($score >= 80 && $score <= 89) {
            $textResponsibility = "You rated yourself at <strong>{$score}%</strong>, which reflects a strong sense of ownership and dependability. This indicates that you see yourself as someone who takes commitments seriously and follows through consistently.";
        } elseif ($score >= 70 && $score <= 79) {
            $textResponsibility = "Your self-assessment stands at <strong>{$score}%</strong>, suggesting a steady commitment to responsibility and follow-through. This indicates that you view yourself as reliable in many situations, with opportunities to further enhance your consistency and sense of accountability.";
        } elseif ($score >= 60 && $score <= 69) {
            $textResponsibility = "You rated yourself at <strong>{$score}%</strong>, indicating that while you value responsibility and accountability, you may find it challenging to maintain them consistently, particularly under pressure or in ambiguous situations.";
        } elseif ($score < 60) {
            $textResponsibility = "With a self-rating of <strong>{$score}%</strong>, you acknowledge that while you value responsibility and accountability, there is room for growth in consistently demonstrating these qualities across different contexts.";
        }
    }

    if ($label === 'Honesty and Integrity' && $type === 'self') {
        if ($score >= 90 && $score <= 100) {
            $textHonesty = "With a self-assessment score of <strong>{$score}%</strong>, you demonstrate a deep-rooted commitment to truthfulness and ethical consistency. You see yourself as someone who acts with moral clarity and fairness, and this strong score reflects your belief in consistently upholding your values.";
        } elseif ($score >= 80 && $score <= 89) {
            $textHonesty = "Your self-assessment stands at <strong>{$score}%</strong>, suggesting a stable personal commitment to truthfulness and ethical behavior. This reflects a belief that you generally act with fairness and moral clarity, though there may still be moments where deeper consistency can be pursued.";
        } elseif ($score >= 70 && $score <= 79) {
            $textHonesty = "You rated yourself at <strong>{$score}%</strong>. This score indicates that you view honesty and integrity as personal strengths, though you may acknowledge occasional inconsistencies or areas where your values and actions could align more closely.";
        } elseif ($score >= 60 && $score <= 69) {
            $textHonesty = "A self-assessment score of <strong>{$score}%</strong> indicates a recognition of the importance of honesty and integrity, along with awareness of potential inconsistencies or uncertainty.";
        } elseif ($score < 60) {
            $textHonesty = "You rated yourself at <strong>{$score}%</strong>. This suggests an honest recognition of the challenges you may face in consistently practicing truthfulness or ethical behavior, offering a clear starting point for deeper alignment between values and actions.";
        }
    }

    if ($label === 'Empathy and Compassion' && $type === 'self') {
        if ($score >= 90 && $score <= 100) {
            $textEmpathy = "You rated yourself at <strong>{$score}%</strong>. This indicates a strong belief in your ability to connect emotionally with others, listen with understanding, and respond with kindness, marking empathy and compassion as central to your leadership approach.";
        } elseif ($score >= 80 && $score <= 89) {
            $textEmpathy = "You rated yourself at <strong>{$score}%</strong>, indicating that empathy and compassion are central to your leadership. This may reflect your high personal standards for emotional intelligence and connection with others.";
        } elseif ($score >= 70 && $score <= 79) {
            $textEmpathy = "With a self-assessment of <strong>{$score}%</strong>, you present a balanced self-view, showing that you value empathy and compassion while also recognizing that there may be moments where deeper emotional presence and responsiveness could be further developed.";
        } elseif ($score >= 60 && $score <= 69) {
            $textEmpathy = "You rated yourself at <strong>{$score}%</strong>. This indicates that while you may exhibit empathy and compassion in some scenarios, you also see space for strengthening your ability to connect with others on a more consistent or deeper level.";
        } elseif ($score < 60) {
            $textEmpathy = "With a score of <strong>{$score}%</strong>, you demonstrate self-awareness of the challenges in consistently expressing empathy and compassion consistently. This could suggest a desire to grow in emotional connection and attunement, especially in interpersonal or team settings.";
        }
    }

    if ($label === 'Humility and Service' && $type === 'self') {
        if ($score >= 90 && $score <= 100) {
            $textHumility = "With a self-assessment score of <strong>{$score}%</strong>, you see yourself as someone who prioritizes collective well-being, values others’ contributions, and leads with humility and a spirit of service.";
        } elseif ($score >= 80 && $score <= 89) {
            $textHumility = "You rated yourself at <strong>{$score}%</strong>. This suggests that you see humility and service as key to how you lead and interact with others, valuing contribution over credit and putting shared success above individual recognition.";
        } elseif ($score >= 70 && $score <= 79) {
            $textHumility = "Your self-rating of <strong>{$score}%</strong> reflects a belief in belief in the importance of humility and serving others, with an opportunity to deepen the consistency of these qualities across different leadership or interpersonal contexts.";
        } elseif ($score >= 60 && $score <= 69) {
            $textHumility = "You rated yourself at <strong>{$score}%</strong>. This suggests an appreciation for humility and service, while also indicating moments where self-focus or task-orientation may overshadow a consistent spirit of service.";
        } elseif ($score < 60) {
            $textHumility = "With a self-assessment score of <strong>{$score}%</strong>, you reflect self-awareness around the challenges of maintaining humility or prioritizing service in fast-paced or high-stakes environments, and open space for personal development in this area.";
        }
    }

    if ($label === 'Patience and Gratitude' && $type === 'self') {
        if ($score >= 90 && $score <= 100) {
            $textPatience = "You rated yourself at <strong>{$score}%</strong>. This score suggests a strong personal foundation in remaining composed under stress and appreciating the positive aspects of your journey and relationships, even in demanding circumstances.";
        } elseif ($score >= 80 && $score <= 89) {
            $textPatience = "With a self-assessment of <strong>{$score}%</strong>, you demonstrate a mature sense of emotional regulation and thankfulness, suggesting that you value calm perseverance and actively recognize the good in both people and situations.";
        } elseif ($score >= 70 && $score <= 79) {
            $textPatience = "You rated yourself at <strong>{$score}%</strong>. This score indicates a solid personal tendency toward patience and appreciation, while also recognizing that these qualities may sometimes be tested, especially in high-pressure or uncertain settings.";
        } elseif ($score >= 60 && $score <= 69) {
            $textPatience = "You rated yourself at <strong>{$score}%</strong>. This score indicates that while you may demonstrate patience and appreciation in some settings, you also recognize room for growth in consistently applying these qualities under stress or in fast-paced situations.";
        } elseif ($score < 60) {
            $textPatience = "With a self-assessment of <strong>{$score}%</strong>, you recognize that patience and gratitude are areas with potential for development, particularly in challenging moments when composure and appreciation are most needed.";
        }
    }

    if ($label === 'Responsibility and Accountability' && $type === 'stakeholder') {
        if ($score2 >= 90 && $score2 <= 100) {
            $stakeholderResponsibility = "You rated at <strong>{$score}%</strong>, reflecting a strong and consistent sense of ownership and dependability. This shows that you take commitments seriously and are trusted to follow through reliably.";
        } elseif ($score2 >= 80 && $score2 <= 89) {
            $stakeholderResponsibility = "A score of <strong>{$score}%</strong>, reflects a strong perception of your reliability and commitment. You are seen as someone who takes responsibility seriously and generally follows through on your promises.";
        } elseif ($score2 >= 70 && $score2 <= 79) {
            $stakeholderResponsibility = "You were rated at <strong>{$score}%</strong>, indicating a solid foundation of dependability, while leaving room for more consistent follow-through. It reflects recognition of your effort to take ownership, with potential to strengthen accountability under pressure.";
        } elseif ($score2 >= 60 && $score2 <= 69) {
            $stakeholderResponsibility = "A score of <strong>{$score}%</strong>, suggests that while responsibility is acknowledged as part of your character, there may be moments of inconsistency. It highlights a development area to build more dependable patterns and follow-through.";
        } elseif ($score2 < 60) {
            $stakeholderResponsibility = "With a score of <strong>{$score}%</strong>, there is a clear opportunity to enhance your reliability, consistency, and sense of ownership in your commitments.";
        }
    }

    if ($label === 'Honesty and Integrity' && $type === 'stakeholder') {
        if ($score2 >= 90 && $score2 <= 100) {
            $stakeholderHonesty = "You rated at <strong>{$score2}%</strong>, This reflects a deeply rooted commitment to truthfulness, fairness, and ethical consistency across your actions and decisions.";
        } elseif ($score2 >= 80 && $score2 <= 89) {
            $stakeholderHonesty = "A score of <strong>{$score2}%</strong>, indicates that honesty and integrity are key components of how you are perceived. You are seen as fair, sincere, and guided by ethical standards. ";
        } elseif ($score2 >= 70 && $score2 <= 79) {
            $stakeholderHonesty = "You were rated at <strong>{$score2}%</strong>, indicating a generally positive perception of your ethical grounding and fairness. However, there may still be room for deeper consistency in principled behavior.";
        } elseif ($score2 >= 60 && $score2 <= 69) {
            $stakeholderHonesty = "A score of <strong>{$score2}%</strong>, suggests that while some commitment to ethical behavior is visible, greater clarity and alignment with core values can be developed.";
        } elseif ($score2 < 60) {
            $stakeholderHonesty = "A rating of <strong>{$score2}%</strong>, indicates a notable gap in perceived or actual ethical consistency. This is a significant opportunity to reinforce transparency, fairness, and trust in your actions.";
        }
    }

    if ($label === 'Empathy and Compassion' && $type === 'stakeholder') {
        if ($score2 >= 90 && $score2 <= 100) {
            $stakeholderEmpathy = "You rated at <strong>{$score2}%</strong>. This shows a strong sense of emotional intelligence, care, and attentiveness toward others, a foundational aspect of compassionate leadership.";
        } elseif ($score2 >= 80 && $score2 <= 89) {
            $stakeholderEmpathy = "A score of <strong>{$score2}%</strong>, reflects that you are generally seen as emotionally aware and considerate. You likely strive to understand others' perspectives and build meaningful connections.";
        } elseif ($score >= 70 && $score <= 79) {
            $stakeholderEmpathy = "A score of <strong>{$score2}%</strong>, suggests that empathy is a moderately strong aspect of your profile, with room to demonstrate greater emotional responsiveness, particularly under pressure.";
        } elseif ($score >= 60 && $score <= 69) {
            $stakeholderEmpathy = "A rating of <strong>{$score2}%</strong>, suggests limited or inconsistent displays of compassion. Developing deeper emotional attunement can strengthen your interpersonal and team dynamics.";
        } elseif ($score < 60) {
            $stakeholderEmpathy = "You were rated at <strong>{$score2}%</strong>, highlighting a significant opportunity for growth in demonstrating care, emotional connection, and trust in relationships.";
        }
    }

    if ($label === 'Humility and Service' && $type === 'stakeholder') {
        if ($score2 >= 90 && $score2 <= 100) {
            $stakeholderHumility = "With a score of <strong>{$score2}%</strong>, you are seen as someone who consistently demonstrates humility, service, and a commitment to collective success. You are seen as someone who uplifts others and leads with a spirit of contribution.";
        } elseif ($score2 >= 80 && $score2 <= 89) {
            $stakeholderHumility = "A score of <strong>{$score2}%</strong>, suggests that you are viewed as respectful, team-oriented, and someone who values service over self-promotion.";
        } elseif ($score2 >= 70 && $score2 <= 79) {
            $stakeholderHumility = "A score of <strong>{$score2}%</strong>, indicates that while humility and service are part of your value system, there's room to further embrace a selfless, contribution-focused mindset.";
        } elseif ($score2 >= 60 && $score2 <= 69) {
            $stakeholderHumility = "A score of <strong>{$score2}%</strong>, suggests modest demonstration of humility and service. Strengthening this area can help foster collaboration, trust, and shared success.";
        } elseif ($score2 < 60) {
            $stakeholderHumility = "A score of <strong>{$score2}%</strong>, indicates a key development opportunity to reduce self-orientation and adopt a more humility-based, service-driven leadership approach.";
        }
    }

    if ($label === 'Patience and Gratitude' && $type === 'stakeholder') {
        if ($score2 >= 90 && $score2 <= 100) {
            $stakeholderPatience = "With a score of <strong>{$score2}%</strong>, you demonstrate a deeply ingrained capacity to remain calm, resilient, and appreciative, even in high-stress situations. This is a powerful strength in leadership and personal growth.";
        } elseif ($score2 >= 80 && $score2 <= 89) {
            $stakeholderPatience = "You were rated at <strong>{$score2}%</strong>, indicating that you are seen as someone who remains composed and grateful, positively influencing team morale.";
        } elseif ($score2 >= 70 && $score2 <= 79) {
            $stakeholderPatience = "A rating of <strong>{$score2}%</strong>, reflects a generally steady approach, with occasional opportunities to further strengthen your ability to stay calm and appreciative in fast-paced situations.";
        } elseif ($score2 >= 60 && $score2 <= 69) {
            $stakeholderPatience = "A score of <strong>{$score2}%</strong>, suggests a partial but inconsistent display of patience and gratitude. Developing these traits further can improve emotional regulation and resilience.";
        } elseif ($score2 < 60) {
            $stakeholderPatience = "A score of <strong>{$score2}%</strong>, points to a key opportunity to develop emotional control, reduce reactivity, and adopt a more appreciative mindset.";
        }
    }


    if ($label === 'Responsibility and Accountability' && $type === 'summary') {
        if ($mean >= 90 && $mean <= 100) {
            $summaryResponsibility = "You rated yourself at <strong>{$score}%</strong>, while your stakeholders scored you at <strong>{$score2}%</strong>. Your self-perception reflects a strong sense of responsibility, although others may not always recognize it as much as you feel it. Stakeholder feedback places you at the <strong>Role Model</strong> level, suggesting a small gap in demonstrating the full extent of your accountability, but you continue to set a high standard for others to follow.";
        } elseif ($mean >= 80 && $mean <= 89) {
            $summaryResponsibility = "You rated yourself at <strong>{$score}%</strong>, while your stakeholders scored you at <strong>{$score2}%</strong>. Your self-assessment suggests confidence in your responsibility, though your colleagues may see some areas for improvement. Stakeholder feedback places you at the <strong>Influencer</strong> level, recognizing your ability to inspire others with your reliable actions, while there's an opportunity for more visible consistency.";
        } elseif ($mean >= 70 && $mean <= 79) {
            $summaryResponsibility = "You rated yourself at <strong>{$score}%</strong>, while your stakeholders scored you at <strong>{$score2}%</strong>. While you feel responsible, your colleagues may not see this as clearly. Stakeholder feedback places you at the <strong>Practitioner</strong> level, showing that you're meeting expectations but there's room for greater visibility and impact.";
        } elseif ($mean >= 60 && $mean <= 69) {
            $summaryResponsibility = "You rated yourself at <strong>{$score}%</strong>, while your stakeholders scored you at <strong>{$score2}%</strong>. Your perception of responsibility is stronger than what others currently see. Stakeholder feedback places you at the <strong>Aspirant</strong> level, signaling that while you're aware of the virtue, there's potential for more consistent follow-through to be visible to your peers.";
        } elseif ($mean < 60) {
            $summaryResponsibility = "You rated yourself at <strong>{$score}%</strong>, while your stakeholders scored you at <strong>{$score2}%</strong>. There's a clear gap here, indicating that you see yourself as more responsible than others perceive you to be. Stakeholder feedback places you at the <strong>Initiator</strong> level, suggesting that you may need to focus on ensuring your actions align with your intentions.";
        }
    }

    if ($label === 'Honesty and Integrity' && $type === 'summary') {
        if ($mean >= 90 && $mean <= 100) {
            $summaryHonesty = "You rated yourself at <strong>{$score}%</strong>, while your stakeholders scored you at <strong>{$score2}%</strong>.You perceive yourself as highly principled and ethical, but your colleagues may not see this as consistently as you feel. Stakeholder feedback places you at the <strong>Role Model</strong> level, suggesting an opportunity to ensure your integrity and honesty are fully visible to others.";
        } elseif ($mean >= 80 && $mean <= 89) {
            $summaryHonesty = "You rated yourself at <strong>{$score}%</strong>, while your stakeholders scored you at <strong>{$score2}%</strong>. Your honesty and integrity are important to you, but others may see fewer instances of this virtue. Stakeholder feedback places you at the <strong>Influencer</strong> level, suggesting you are a model for others but may need to make these traits more visible in day-to-day actions.";
        } elseif ($mean >= 70 && $mean <= 79) {
            $summaryHonesty = "You rated yourself at <strong>{$score}%</strong>, while your stakeholders scored you at <strong>{$score2}%</strong>. Your commitment to honesty and integrity is solid, though others may see it as more inconsistent. Stakeholder feedback places you at the <strong>Practitioner</strong> level, meaning you're meeting expectations, but there is room for improvement in maintaining a consistent standard of ethical behavior.";
        } elseif ($mean >= 60 && $mean <= 69) {
            $summaryHonesty = "You rated yourself at <strong>{$score}%</strong>, while your stakeholders scored you at <strong>{$score2}%</strong>. You acknowledge the importance of integrity but may not always live up to this in a visible way. Stakeholder feedback places you at the <strong>Aspirant</strong> level, indicating that you’re still developing your consistency in being honest and ethical in your actions.";
        } elseif ($mean < 60) {
            $summaryHonesty = "You rated yourself at <strong>{$score}%</strong>, while your stakeholders scored you at <strong>{$score2}%</strong>. There is a gap between how you perceive your honesty and integrity and how others experience it. Stakeholder feedback places you at the <strong>Initiator</strong> level, indicating that you are at the start of this journey and need more consistent application of honesty and ethical behavior.";
        }
    }

    if ($label === 'Empathy and Compassion' && $type === 'summary') {
        if ($mean >= 90 && $mean <= 100) {
            $summaryEmpathy = "You rated yourself at <strong>{$score}%</strong>, while your stakeholders scored you at <strong>{$score2}%</strong>. Your self-perception places you highly in empathy and compassion, seeing yourself as deeply caring and emotionally present for others. However, the significant difference between your self-assessment and stakeholder feedback suggests that others may not perceive this as strongly. Stakeholder feedback indicates you are at the <strong>Role Model</strong> level, meaning you are in the early stages of developing this virtue. To align your self-perception with reality, focus on demonstrating more visible care and emotional presence in your interactions.";
        } elseif ($mean >= 80 && $mean <= 89) {
            $summaryEmpathy = "•	You rated yourself at <strong>{$score}%</strong>, while your stakeholders rated you at <strong>{$score2}%</strong>. Your self-assessment indicates that you believe you demonstrate empathy and compassion effectively. However, your stakeholders’ lower rating—placing you at the <strong>Influencer</strong> level—suggests that these qualities may not be as visible or impactful to others as you perceive. This presents an opportunity to align perception with intention by consistently expressing care and empathy in your daily interactions.";
        } elseif ($mean >= 70 && $mean <= 79) {
            $summaryEmpathy = "You rated yourself at <strong>{$score}%</strong>, while your stakeholders rated you at <strong>{$score2}%</strong>. Your self-assessment suggests you believe you consistently demonstrate empathy and compassion. However, stakeholder feedback places you at the <strong>Practitioner</strong> level, indicating that while you see yourself as dependable in this area, others may not experience your empathy as strongly. To bridge this gap, focus on enhancing your emotional engagement and being more mindful of how your actions are perceived by others.";
        } elseif ($mean >= 60 && $mean <= 69) {
            $summaryEmpathy = "You rated yourself at <strong>{$score}%</strong>, while your stakeholders rated you at <strong>{$score2}%</strong>. Your self-assessment reflects a belief that empathy and compassion are central to your behavior. However, stakeholder feedback places you at the <strong>Aspirant</strong> level, suggesting that these qualities may not be consistently visible to others. This gap highlights the need for more intentional and outward expressions of care in your interactions. Enhancing your emotional presence can help align perception with your intentions.";
        } elseif ($mean < 60) {
            $summaryEmpathy = "You rated yourself at <strong>{$score}%</strong>, while your stakeholders rated you at <strong>{$score2}%</strong>. Your self-perception suggests strong confidence in your empathy and compassion. However, your stakeholders have placed you at the <strong>Initiator</strong> level, indicating a notable disconnect between your intentions and how your behavior is perceived. This presents a clear growth opportunity: focus on increasing the visibility, consistency, and emotional impact of your empathetic actions to build stronger connections with others.";
        }
    }

    if ($label === 'Humility and Service' && $type === 'summary') {
        if ($mean >= 90 && $mean <= 100) {
            $summaryHumility = "You rated yourself at <strong>{$score}%</strong>, while your stakeholders rated you at <strong>{$score2}%</strong>. Your self-assessment shows that you view humility and service as core strengths. However, your stakeholders rated you even higher, placing you at the <strong>Role Model</strong> level. This positive gap highlights that others deeply recognize and value your humility and dedication to serving others, perhaps even more than you do. Continue leading with authenticity and care; your impact is already significant and deeply appreciated.";
        } elseif ($mean >= 80 && $mean <= 89) {
            $summaryHumility = "You rated yourself at <strong>{$score}%</strong>, while your stakeholders rated you at <strong>{$score2}%</strong>. You see yourself as someone who demonstrates high levels of humility and service, but your stakeholders rated you even higher, placing you at the <strong>Influencer</strong> level. This slight but positive gap suggests that while you may be modest in self-assessment, others clearly view your actions as impactful and uplifting. Maintain your service-driven mindset, knowing it resonates strongly with those around you.";
        } elseif ($mean >= 70 && $mean <= 79) {
            $summaryHumility = "You rated yourself at <strong>{$score}%</strong>, while your stakeholders scored you at <strong>{$score2}%</strong>. Your high self-assessment shows that you feel confident in your humility and service, but your stakeholders have rated you even higher. This suggests that others view your humility and service as stronger than you perceive them to be. While you rank yours higher but others see you as a <strong>Practitioner</strong>, and this feedback highlights the importance of continuing to embody these values consistently.";
        } elseif ($mean >= 60 && $mean <= 69) {
            $summaryHumility = "You rated yourself at <strong>{$score}%</strong>, while your stakeholders rated you at <strong>{$score2}%</strong>. Your self-assessment indicates that you view humility and service as core strengths. Interestingly, your stakeholders rated you even higher, placing you at the <strong>Aspirant</strong> level. This positive gap suggests that others see you as more consistent and impactful in this virtue than you perceive yourself to be. Continue cultivating humility and service—your peers already value these qualities in you.";
        } elseif ($mean < 60) {
            $summaryHumility = "You rated yourself at <strong>{$score}%</strong>, while your stakeholders rated you at <strong>{$score2}%</strong>. While you see humility and service as personal strengths, your stakeholders rated you even higher, placing you at the <strong>Initiator</strong> level. This positive misalignment shows that others deeply value the way you uplift and support them. Continue to embody these qualities with confidence—your actions are making a stronger impact than you may realize.";
        }
    }

    if ($label === 'Patience and Gratitude' && $type === 'summary') {
        if ($mean >= 90 && $mean <= 100) {
            $summaryPatience = "You rated yourself at <strong>{$score}%</strong>, while your stakeholders scored you at <strong>{$score2}%</strong>. Your self-assessment suggests you believe there is still room to grow in demonstrating patience and gratitude. However, your stakeholders have rated you higher, placing you at the <strong>Role Model</strong> level. This positive perception gap indicates that others see these virtues more clearly in your behavior than you do yourself. Continue nurturing patience and gratitude—your presence already leaves a meaningful impact on those around you.";
        } elseif ($mean >= 80 && $mean <= 89) {
            $summaryPatience = "You rated yourself at <strong>{$score}%</strong>, while your stakeholders scored you at <strong>{$score2}%</strong>. Your self-assessment indicates that you believe you are demonstrating patience and gratitude effectively. However, your stakeholders place you at the <strong>Influencer</strong> level, suggesting your actions may not be as visible or consistent to others as you perceive them to be. This gap highlights the need to reflect on how your intentions translate into everyday interactions. Focusing on being more mindful and consistent in expressing patience and appreciation can help align perception with intention.";
        } elseif ($mean >= 70 && $mean <= 79) {
            $summaryPatience = "You rated yourself at <strong>{$score}%</strong>, while your stakeholders scored you at <strong>{$score2}%</strong>. Your self-assessment indicates that you view yourself as demonstrating patience and gratitude more consistently than others perceive. Stakeholder feedback places you at the <strong>Practitioner</strong> level, highlighting clear potential for growth. This perception gap suggests a need to align intention with action—others may not yet fully experience your efforts. To close this gap, focus on making your patience and gratitude more visible in your day-to-day interactions.";
        } elseif ($mean >= 60 && $mean <= 69) {
            $summaryPatience = "You rated yourself at <strong>{$score}%</strong>, while your stakeholders scored you at <strong>{$score2}%</strong>. Your self-assessment places you in the <strong>Aspirant</strong> range, indicating that you recognize the need for growth in patience and gratitude. However, stakeholders have rated you slightly higher, suggesting they already see more development in you than you may realize. This positive gap highlights untapped potential—keep working on consistently demonstrating these virtues, as others are noticing your progress.";
        } elseif ($mean < 60) {
            $summaryPatience = "You rated yourself at <strong>{$score}%</strong>, while your stakeholders scored you at <strong>{$score2}%</strong>. Your self-assessment indicates that you perceive yourself as demonstrating stronger patience and gratitude. However, stakeholder feedback places you at the <strong>Initiator</strong> level, recognizing your early-stage efforts in this area. This presents an opportunity for you to focus on making your progress more visible by consistently demonstrating patience and gratitude in your interactions.";
        }
    }

    $comments = [
        'self' => [
            'Responsibility and Accountability' => $textResponsibility,
            'Honesty and Integrity' => $textHonesty,
            'Empathy and Compassion' => $textEmpathy,
            'Humility and Service' => $textHumility,
            'Patience and Gratitude' => $textPatience,
        ],
        'stakeholder' => [
            'Responsibility and Accountability' => $stakeholderResponsibility,
            'Honesty and Integrity' => $stakeholderHonesty,
            'Empathy and Compassion' => $stakeholderEmpathy,
            'Humility and Service' => $stakeholderHumility,
            'Patience and Gratitude' => $stakeholderPatience,
        ],
        'summary' => [
            'Responsibility and Accountability' => $summaryResponsibility,
            'Honesty and Integrity' => $summaryHonesty,
            'Empathy and Compassion' => $summaryEmpathy,
            'Humility and Service' => $summaryHumility,
            'Patience and Gratitude' => $summaryPatience,
        ],
    ];

    return $comments[$type][$label] ?? "Score: <span class=\"data1\"><strong>{$score}%</strong></span>";
}