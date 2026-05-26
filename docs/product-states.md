# Product States

## Draft

`draft` means the product card is being prepared. A catalog administrator can edit the product, fill attributes, correct category, and update commercial fields. The product must not be treated as ready for public display yet. Missing required attributes are allowed in this state because work is still in progress.

## Ready

`ready` means the product card looks complete from the catalog team's point of view. It should have the required category attributes filled and typed correctly. A responsible user can move it toward publication after the rules are checked.

## Published

`published` means the product can be shown in catalog flows and used by external consumers of the catalog data. A published product must not miss required category attributes. The publication action is a business transition, not only a UI toggle.

## Archived

`archived` means the product is no longer active in the catalog process, but its history may still be needed for audit or reporting. The product should not normally return to public display without an explicit business decision.

## Allowed Transitions

- `draft -> ready`: the card is filled enough for review.
- `ready -> published`: the product passes publication checks.
- `published -> archived`: the product is removed from active catalog flow.

## Why `is_active` Is Not Enough

The inherited `is_active` flag is useful for simple CRUD visibility, but it does not describe the business process. It does not explain whether the product is incomplete, ready for review, published, or archived. A future status field or dropdown also does not replace the process description by itself. The team still needs a shared understanding of allowed transitions and the rule behind publication.
