import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CertificateBadgeslistComponent } from './certificate-badgeslist.component';

describe('CertificateBadgeslistComponent', () => {
  let component: CertificateBadgeslistComponent;
  let fixture: ComponentFixture<CertificateBadgeslistComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CertificateBadgeslistComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CertificateBadgeslistComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
