import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { InstructorinvitationlistComponent } from './instructorinvitationlist.component';

describe('InstructorinvitationlistComponent', () => {
  let component: InstructorinvitationlistComponent;
  let fixture: ComponentFixture<InstructorinvitationlistComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ InstructorinvitationlistComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(InstructorinvitationlistComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
