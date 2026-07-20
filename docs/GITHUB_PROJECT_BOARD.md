# GitHub Project Board Setup

أنشئ لوحة مشروع بالأعمدة التالية:

1. `Backlog`
2. `Ready`
3. `In Progress`
4. `In Review`
5. `Done`

## قواعد الانتقال

- **Backlog:** فكرة أو عمل مستقبلي لم يجهز بعد.
- **Ready:** الوصف ومعايير القبول واضحان ويمكن بدء التنفيذ.
- **In Progress:** يوجد Assignee وBranch فعلي.
- **In Review:** تم فتح Pull Request.
- **Done:** تمت المراجعة والدمج وإغلاق الـIssue.

## حقول مقترحة

- Status
- Priority: High / Medium / Low
- Type: Story / Bug / Docs / Test
- Related Requirement: FR-XX / NFR-XX
- Assignee

## Definition of Done للوحة

لا تُنقل المهمة إلى Done إلا بعد:

- [ ] تحقق Acceptance Criteria.
- [ ] اكتمال الاختبار.
- [ ] فتح Pull Request.
- [ ] Review من عضو آخر.
- [ ] Merge إلى `main`.
- [ ] إغلاق الـIssue.
